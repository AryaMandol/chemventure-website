<section class="resources-section" id="resources" data-section="resources">
    <div class="cv-container resources-grid">
        <div class="resources-copy" data-reveal>
            <p class="home-eyebrow">Technical Resources</p>
            <h2>Need technical information?</h2>
            <p>The existing catalogue contains application, pretreatment, curing and coating-thickness guidance. Final downloadable documents can be managed from WordPress as they are approved.</p>
        </div>
        <div class="resource-list" data-reveal>
            <?php chemventure_resource_item( 'resource_powder_guide', 'Powder Coating Guide' ); ?>
            <?php chemventure_resource_item( 'resource_application', 'Application Guidelines' ); ?>
            <?php chemventure_resource_item( 'resource_pretreatment', 'Pretreatment Guidelines' ); ?>
            <?php chemventure_resource_item( 'resource_finish_support', 'Finish Selection Support' ); ?>
            <p class="resource-status" aria-live="polite" data-resource-status></p>
        </div>
    </div>
</section>
