<?php
/**
 * Lead capture, admin management and CSV export.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the private lead post type used by the homepage enquiry form.
 */
function chemventure_register_lead_post_type() {
    $labels = array(
        'name'               => __( 'Leads', 'chemventure' ),
        'singular_name'      => __( 'Lead', 'chemventure' ),
        'menu_name'          => __( 'Leads', 'chemventure' ),
        'name_admin_bar'     => __( 'Lead', 'chemventure' ),
        'all_items'          => __( 'All Leads', 'chemventure' ),
        'edit_item'          => __( 'View Lead', 'chemventure' ),
        'view_item'          => __( 'View Lead', 'chemventure' ),
        'search_items'       => __( 'Search Leads', 'chemventure' ),
        'not_found'          => __( 'No leads found.', 'chemventure' ),
        'not_found_in_trash' => __( 'No leads found in Trash.', 'chemventure' ),
    );

    register_post_type(
        'cv_lead',
        array(
            'labels'              => $labels,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => false,
            'exclude_from_search' => true,
            'show_in_rest'        => false,
            'menu_icon'           => 'dashicons-email-alt',
            'menu_position'       => 26,
            'supports'            => array( 'title' ),
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'capabilities'        => array(
                'create_posts' => 'do_not_allow',
            ),
        )
    );
}
add_action( 'init', 'chemventure_register_lead_post_type' );

/**
 * Lead form submission endpoint.
 */
function chemventure_submit_lead() {
    check_ajax_referer( 'chemventure_submit_lead', 'nonce' );

    $raw = wp_unslash( $_POST );

    // Honeypot submissions are silently accepted without storing anything.
    if ( ! empty( $raw['website'] ) ) {
        wp_send_json_success(
            array( 'message' => __( 'Thank you. Your requirement has been received.', 'chemventure' ) )
        );
    }

    if ( chemventure_lead_rate_limited() ) {
        wp_send_json_error(
            array( 'message' => __( 'Too many requests were received. Please wait a few minutes and try again.', 'chemventure' ) ),
            429
        );
    }

    $name        = sanitize_text_field( $raw['name'] ?? '' );
    $company     = sanitize_text_field( $raw['company'] ?? '' );
    $phone       = sanitize_text_field( $raw['phone'] ?? '' );
    $email       = sanitize_email( $raw['email'] ?? '' );
    $product     = sanitize_text_field( $raw['product'] ?? '' );
    $requirement = sanitize_textarea_field( $raw['requirement'] ?? '' );

    if ( '' === $name || '' === $phone ) {
        wp_send_json_error(
            array( 'message' => __( 'Please provide your name and phone / WhatsApp number.', 'chemventure' ) ),
            422
        );
    }

    if ( ! empty( $raw['email'] ) && ! is_email( $email ) ) {
        wp_send_json_error(
            array( 'message' => __( 'Please enter a valid email address.', 'chemventure' ) ),
            422
        );
    }

    $allowed_products = array(
        '',
        'Pure Epoxy',
        'Epoxy Polyester Hybrid',
        'Pure Polyester',
        'Not sure yet',
    );

    if ( ! in_array( $product, $allowed_products, true ) ) {
        $product = '';
    }

    $title_parts = array_filter( array( $name, $company ) );
    $lead_title  = implode( ' - ', $title_parts );
    $lead_title .= ' - ' . wp_date( 'Y-m-d H:i' );

    $lead_id = wp_insert_post(
        array(
            'post_type'   => 'cv_lead',
            'post_status' => 'publish',
            'post_title'  => $lead_title,
        ),
        true
    );

    if ( is_wp_error( $lead_id ) ) {
        wp_send_json_error(
            array( 'message' => __( 'We could not save your request right now. Please try again or contact the team directly.', 'chemventure' ) ),
            500
        );
    }

    $fields = array(
        'name'         => $name,
        'company'      => $company,
        'phone'        => $phone,
        'email'        => $email,
        'product'      => $product,
        'requirement'  => $requirement,
        'utm_source'   => sanitize_text_field( $raw['utm_source'] ?? '' ),
        'utm_medium'   => sanitize_text_field( $raw['utm_medium'] ?? '' ),
        'utm_campaign' => sanitize_text_field( $raw['utm_campaign'] ?? '' ),
        'utm_content'  => sanitize_text_field( $raw['utm_content'] ?? '' ),
        'utm_term'     => sanitize_text_field( $raw['utm_term'] ?? '' ),
        'gclid'        => sanitize_text_field( $raw['gclid'] ?? '' ),
        'fbclid'       => sanitize_text_field( $raw['fbclid'] ?? '' ),
        'landing_url'  => esc_url_raw( $raw['landing_url'] ?? '' ),
        'referrer'     => esc_url_raw( $raw['referrer'] ?? '' ),
    );

    foreach ( $fields as $key => $value ) {
        update_post_meta( $lead_id, '_cv_' . $key, $value );
    }

    update_post_meta( $lead_id, '_cv_status', 'new' );

    $mail_sent = chemventure_send_lead_notification( $lead_id, $fields );
    update_post_meta( $lead_id, '_cv_mail_sent', $mail_sent ? '1' : '0' );

    wp_send_json_success(
        array(
            'message' => __( 'Thank you. Your requirement has been received. The ChemVenture team can now follow up with you.', 'chemventure' ),
        )
    );
}
add_action( 'wp_ajax_nopriv_chemventure_submit_lead', 'chemventure_submit_lead' );
add_action( 'wp_ajax_chemventure_submit_lead', 'chemventure_submit_lead' );

/**
 * Rate-limit repeated submissions without storing a raw IP address.
 */
function chemventure_lead_rate_limited() {
    $ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

    if ( '' === $ip ) {
        return false;
    }

    $hash = hash_hmac( 'sha256', $ip, wp_salt( 'nonce' ) );
    $key  = 'cv_lead_rate_' . substr( $hash, 0, 24 );
    $hits = (int) get_transient( $key );

    if ( $hits >= 5 ) {
        return true;
    }

    set_transient( $key, $hits + 1, 10 * MINUTE_IN_SECONDS );
    return false;
}

/**
 * Send a plain-text notification email for a newly stored lead.
 *
 * @param int   $lead_id Lead post ID.
 * @param array $fields  Sanitized lead fields.
 * @return bool
 */
function chemventure_send_lead_notification( $lead_id, $fields ) {
    $recipient = chemventure_mod( 'lead_recipient_email', get_option( 'admin_email' ) );
    $recipient = sanitize_email( $recipient );

    if ( ! $recipient ) {
        return false;
    }

    $subject = sprintf(
        /* translators: %s: lead name */
        __( 'New Green Paints enquiry from %s', 'chemventure' ),
        $fields['name']
    );

    $lines = array(
        'A new website enquiry has been received.',
        '',
        'Name: ' . $fields['name'],
        'Company: ' . ( $fields['company'] ?: '-' ),
        'Phone / WhatsApp: ' . $fields['phone'],
        'Email: ' . ( $fields['email'] ?: '-' ),
        'Product: ' . ( $fields['product'] ?: '-' ),
        'Requirement: ' . ( $fields['requirement'] ?: '-' ),
        '',
        'Campaign source: ' . ( $fields['utm_source'] ?: '-' ),
        'Campaign medium: ' . ( $fields['utm_medium'] ?: '-' ),
        'Campaign: ' . ( $fields['utm_campaign'] ?: '-' ),
        'Landing URL: ' . ( $fields['landing_url'] ?: '-' ),
        'Referrer: ' . ( $fields['referrer'] ?: '-' ),
        '',
        'Lead ID: ' . $lead_id,
        'WordPress Admin: ' . admin_url( 'post.php?post=' . $lead_id . '&action=edit' ),
    );

    $headers = array();
    if ( ! empty( $fields['email'] ) ) {
        $headers[] = 'Reply-To: ' . $fields['name'] . ' <' . $fields['email'] . '>';
    }

    return wp_mail( $recipient, $subject, implode( "\n", $lines ), $headers );
}

/**
 * Add the lead details meta box.
 */
function chemventure_lead_meta_boxes() {
    add_meta_box(
        'chemventure-lead-details',
        __( 'Lead Details', 'chemventure' ),
        'chemventure_render_lead_details',
        'cv_lead',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes_cv_lead', 'chemventure_lead_meta_boxes' );

/**
 * Render the lead details meta box.
 *
 * @param WP_Post $post Lead post.
 */
function chemventure_render_lead_details( $post ) {
    wp_nonce_field( 'chemventure_save_lead_status', 'chemventure_lead_status_nonce' );

    $map = array(
        'name'         => __( 'Name', 'chemventure' ),
        'company'      => __( 'Company', 'chemventure' ),
        'phone'        => __( 'Phone / WhatsApp', 'chemventure' ),
        'email'        => __( 'Email', 'chemventure' ),
        'product'      => __( 'Product', 'chemventure' ),
        'requirement'  => __( 'Requirement', 'chemventure' ),
        'utm_source'   => __( 'UTM Source', 'chemventure' ),
        'utm_medium'   => __( 'UTM Medium', 'chemventure' ),
        'utm_campaign' => __( 'UTM Campaign', 'chemventure' ),
        'utm_content'  => __( 'UTM Content', 'chemventure' ),
        'utm_term'     => __( 'UTM Term', 'chemventure' ),
        'gclid'        => __( 'Google Click ID', 'chemventure' ),
        'fbclid'       => __( 'Meta Click ID', 'chemventure' ),
        'landing_url'  => __( 'Landing URL', 'chemventure' ),
        'referrer'     => __( 'Referrer', 'chemventure' ),
    );

    echo '<table class="widefat striped" style="margin-bottom:18px"><tbody>';
    foreach ( $map as $key => $label ) {
        $value = get_post_meta( $post->ID, '_cv_' . $key, true );
        if ( '' === $value ) {
            $value = '-';
        }
        echo '<tr><th style="width:180px">' . esc_html( $label ) . '</th><td>' . nl2br( esc_html( $value ) ) . '</td></tr>';
    }
    echo '</tbody></table>';

    $status = get_post_meta( $post->ID, '_cv_status', true ) ?: 'new';
    ?>
    <p><label for="cv-lead-status"><strong><?php esc_html_e( 'Lead status', 'chemventure' ); ?></strong></label></p>
    <select name="cv_lead_status" id="cv-lead-status">
        <?php
        $statuses = array(
            'new'       => __( 'New', 'chemventure' ),
            'contacted' => __( 'Contacted', 'chemventure' ),
            'qualified' => __( 'Qualified', 'chemventure' ),
            'closed'    => __( 'Closed', 'chemventure' ),
        );
        foreach ( $statuses as $key => $label ) {
            printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $key ), selected( $status, $key, false ), esc_html( $label ) );
        }
        ?>
    </select>
    <?php
}

/**
 * Save editable lead metadata.
 */
function chemventure_save_lead_status( $post_id ) {
    if ( ! isset( $_POST['chemventure_lead_status_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['chemventure_lead_status_nonce'] ) ), 'chemventure_save_lead_status' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $status   = sanitize_key( wp_unslash( $_POST['cv_lead_status'] ?? 'new' ) );
    $allowed  = array( 'new', 'contacted', 'qualified', 'closed' );
    $status   = in_array( $status, $allowed, true ) ? $status : 'new';
    update_post_meta( $post_id, '_cv_status', $status );
}
add_action( 'save_post_cv_lead', 'chemventure_save_lead_status' );

/**
 * Customize lead-list columns.
 */
function chemventure_lead_columns( $columns ) {
    return array(
        'cb'          => $columns['cb'],
        'title'       => __( 'Lead', 'chemventure' ),
        'cv_status'   => __( 'Status', 'chemventure' ),
        'cv_contact'  => __( 'Contact', 'chemventure' ),
        'cv_product'  => __( 'Product', 'chemventure' ),
        'cv_campaign' => __( 'Campaign', 'chemventure' ),
        'date'        => __( 'Received', 'chemventure' ),
    );
}
add_filter( 'manage_cv_lead_posts_columns', 'chemventure_lead_columns' );

/**
 * Render lead-list custom columns.
 */
function chemventure_lead_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'cv_status':
            $status = get_post_meta( $post_id, '_cv_status', true ) ?: 'new';
            echo '<strong>' . esc_html( ucfirst( $status ) ) . '</strong>';
            break;
        case 'cv_contact':
            $phone = get_post_meta( $post_id, '_cv_phone', true );
            $email = get_post_meta( $post_id, '_cv_email', true );
            if ( $phone ) {
                echo esc_html( $phone );
            }
            if ( $email ) {
                echo '<br><a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
            }
            break;
        case 'cv_product':
            echo esc_html( get_post_meta( $post_id, '_cv_product', true ) ?: '-' );
            break;
        case 'cv_campaign':
            $source   = get_post_meta( $post_id, '_cv_utm_source', true );
            $campaign = get_post_meta( $post_id, '_cv_utm_campaign', true );
            echo esc_html( $source ?: '-' );
            if ( $campaign ) {
                echo '<br><small>' . esc_html( $campaign ) . '</small>';
            }
            break;
    }
}
add_action( 'manage_cv_lead_posts_custom_column', 'chemventure_lead_column_content', 10, 2 );

/**
 * Register a simple CSV export submenu.
 */
function chemventure_lead_export_menu() {
    add_submenu_page(
        'edit.php?post_type=cv_lead',
        __( 'Export Leads', 'chemventure' ),
        __( 'Export CSV', 'chemventure' ),
        'manage_options',
        'chemventure-lead-export',
        'chemventure_lead_export_page'
    );
}
add_action( 'admin_menu', 'chemventure_lead_export_menu' );

/**
 * Render the CSV export screen.
 */
function chemventure_lead_export_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $url = wp_nonce_url( admin_url( 'admin-post.php?action=chemventure_export_leads' ), 'chemventure_export_leads' );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Export Leads', 'chemventure' ); ?></h1>
        <p><?php esc_html_e( 'Download all currently stored website leads as a CSV file.', 'chemventure' ); ?></p>
        <p><a class="button button-primary" href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Download CSV', 'chemventure' ); ?></a></p>
    </div>
    <?php
}

/**
 * Stream stored leads as CSV.
 */
function chemventure_export_leads() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have permission to export leads.', 'chemventure' ) );
    }

    check_admin_referer( 'chemventure_export_leads' );

    $query = new WP_Query(
        array(
            'post_type'      => 'cv_lead',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'no_found_rows'  => true,
        )
    );

    nocache_headers();
    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=chemventure-leads-' . gmdate( 'Y-m-d' ) . '.csv' );

    $output = fopen( 'php://output', 'w' );
    if ( false === $output ) {
        exit;
    }

    fputcsv(
        $output,
        array( 'Received', 'Status', 'Name', 'Company', 'Phone', 'Email', 'Product', 'Requirement', 'UTM Source', 'UTM Medium', 'UTM Campaign', 'UTM Content', 'UTM Term', 'Landing URL', 'Referrer' ),
        ',',
        '"',
        ''
    );

    foreach ( $query->posts as $lead ) {
        $get = static function ( $key ) use ( $lead ) {
            return get_post_meta( $lead->ID, '_cv_' . $key, true );
        };

        fputcsv(
            $output,
            array(
                get_the_date( 'Y-m-d H:i:s', $lead ),
                $get( 'status' ),
                $get( 'name' ),
                $get( 'company' ),
                $get( 'phone' ),
                $get( 'email' ),
                $get( 'product' ),
                $get( 'requirement' ),
                $get( 'utm_source' ),
                $get( 'utm_medium' ),
                $get( 'utm_campaign' ),
                $get( 'utm_content' ),
                $get( 'utm_term' ),
                $get( 'landing_url' ),
                $get( 'referrer' ),
            ),
            ',',
            '"',
            ''
        );
    }

    fclose( $output );
    exit;
}
add_action( 'admin_post_chemventure_export_leads', 'chemventure_export_leads' );
