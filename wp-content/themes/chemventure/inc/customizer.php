<?php
/**
 * Theme Customizer settings for the single-page homepage.
 *
 * @package ChemVenture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register homepage settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function chemventure_customize_register( $wp_customize ) {
    $wp_customize->add_panel(
        'chemventure_homepage',
        array(
            'title'       => __( 'ChemVenture Homepage', 'chemventure' ),
            'description' => __( 'Manage the primary content, imagery, contact details and resource links used on the Green Paints landing page.', 'chemventure' ),
            'priority'    => 30,
        )
    );

    $wp_customize->add_section(
        'chemventure_home_hero',
        array(
            'title'    => __( 'Hero Content', 'chemventure' ),
            'panel'    => 'chemventure_homepage',
            'priority' => 10,
        )
    );

    chemventure_add_text_control( $wp_customize, 'hero_eyebrow', 'chemventure_home_hero', __( 'Hero eyebrow', 'chemventure' ), 'Green Paints by ChemVenture India' );
    chemventure_add_text_control( $wp_customize, 'hero_title', 'chemventure_home_hero', __( 'Hero title', 'chemventure' ), 'Industrial powder coatings built for reliable performance.', 'sanitize_textarea_field', 'textarea' );
    chemventure_add_text_control( $wp_customize, 'hero_lead', 'chemventure_home_hero', __( 'Hero supporting copy', 'chemventure' ), 'Epoxy, epoxy polyester hybrid and pure polyester powder coating solutions for consistent finish, protection and dependable application.', 'sanitize_textarea_field', 'textarea' );

    $wp_customize->add_section(
        'chemventure_home_images',
        array(
            'title'    => __( 'Homepage Images', 'chemventure' ),
            'panel'    => 'chemventure_homepage',
            'priority' => 20,
        )
    );

    chemventure_add_image_control( $wp_customize, 'hero_image', __( 'Hero image', 'chemventure' ) );
    chemventure_add_image_control( $wp_customize, 'about_image', __( 'About / coating process image', 'chemventure' ) );
    chemventure_add_image_control( $wp_customize, 'quality_image', __( 'Quality / laboratory image', 'chemventure' ) );
    chemventure_add_image_control( $wp_customize, 'operations_image', __( 'Operations / supply image', 'chemventure' ) );

    $wp_customize->add_section(
        'chemventure_home_about',
        array(
            'title'    => __( 'About Content', 'chemventure' ),
            'panel'    => 'chemventure_homepage',
            'priority' => 30,
        )
    );

    chemventure_add_text_control( $wp_customize, 'about_title', 'chemventure_home_about', __( 'About heading', 'chemventure' ), 'Powder coating expertise backed by ChemVenture.', 'sanitize_textarea_field', 'textarea' );
    chemventure_add_text_control( $wp_customize, 'about_lead', 'chemventure_home_about', __( 'About lead', 'chemventure' ), 'ChemVenture India Private Limited was founded in 2010 and later expanded into chemical intermediates and powder paints for the coatings industry. Green Paints is the company\'s powder coating range.', 'sanitize_textarea_field', 'textarea' );
    chemventure_add_text_control( $wp_customize, 'about_body', 'chemventure_home_about', __( 'About body', 'chemventure' ), 'The business focuses on product development, consistent quality, operational efficiency and customer value. Its supplied company profile also records customers ranging from job coaters to OEMs.', 'sanitize_textarea_field', 'textarea' );

    $wp_customize->add_section(
        'chemventure_contact',
        array(
            'title'    => __( 'Contact Details', 'chemventure' ),
            'panel'    => 'chemventure_homepage',
            'priority' => 40,
        )
    );

    chemventure_add_text_control( $wp_customize, 'contact_phone', 'chemventure_contact', __( 'Phone', 'chemventure' ), '', 'sanitize_text_field' );
    chemventure_add_text_control( $wp_customize, 'contact_whatsapp', 'chemventure_contact', __( 'WhatsApp number', 'chemventure' ), '', 'sanitize_text_field' );
    chemventure_add_text_control( $wp_customize, 'contact_email', 'chemventure_contact', __( 'Sales email', 'chemventure' ), '', 'sanitize_email', 'email' );
    chemventure_add_text_control( $wp_customize, 'corporate_office', 'chemventure_contact', __( 'Corporate office', 'chemventure' ), '', 'sanitize_textarea_field', 'textarea' );
    chemventure_add_text_control( $wp_customize, 'factory_address', 'chemventure_contact', __( 'Factory', 'chemventure' ), '', 'sanitize_textarea_field', 'textarea' );

    $wp_customize->add_section(
        'chemventure_resources',
        array(
            'title'    => __( 'Technical Resources', 'chemventure' ),
            'panel'    => 'chemventure_homepage',
            'priority' => 50,
        )
    );

    chemventure_add_text_control( $wp_customize, 'resource_powder_guide', 'chemventure_resources', __( 'Powder Coating Guide URL', 'chemventure' ), '', 'esc_url_raw', 'url' );
    chemventure_add_text_control( $wp_customize, 'resource_application', 'chemventure_resources', __( 'Application Guidelines URL', 'chemventure' ), '', 'esc_url_raw', 'url' );
    chemventure_add_text_control( $wp_customize, 'resource_pretreatment', 'chemventure_resources', __( 'Pretreatment Guidelines URL', 'chemventure' ), '', 'esc_url_raw', 'url' );
    chemventure_add_text_control( $wp_customize, 'resource_finish_support', 'chemventure_resources', __( 'Finish Selection Support URL', 'chemventure' ), '', 'esc_url_raw', 'url' );
}
add_action( 'customize_register', 'chemventure_customize_register' );

/**
 * Add a text-like Customizer field.
 */
function chemventure_add_text_control( $wp_customize, $setting_id, $section, $label, $default = '', $sanitize_callback = 'sanitize_text_field', $type = 'text' ) {
    $wp_customize->add_setting(
        $setting_id,
        array(
            'default'           => $default,
            'sanitize_callback' => $sanitize_callback,
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        $setting_id,
        array(
            'label'   => $label,
            'section' => $section,
            'type'    => $type,
        )
    );
}

/**
 * Add an image control to the homepage-images section.
 */
function chemventure_add_image_control( $wp_customize, $setting_id, $label ) {
    $wp_customize->add_setting(
        $setting_id,
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            $setting_id,
            array(
                'label'   => $label,
                'section' => 'chemventure_home_images',
            )
        )
    );
}
