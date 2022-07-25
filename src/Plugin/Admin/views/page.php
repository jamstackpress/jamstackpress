<div class="wrap">
    <h1><strong>JAMStackPress</strong></h1>
    <p><?php _e('Configure the plugin settings and power-up your WordPress site in a few clicks!'); ?></p>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
    <?php
        settings_fields('jamstackpress-options');
        do_settings_sections('jamstackpress-admin');
        submit_button();
    ?>
    </form>
</div>