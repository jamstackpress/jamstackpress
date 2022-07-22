<?php
if (is_admin_bar_showing() && $url = get_option('jamstackpress_build_webhook_url')) {
    ?>

    <script>
        jQuery('li#wp-admin-bar-jamstackpress_build_frontend .ab-item').on('click', () => {
            jQuery
                .post('<?php echo $url; ?>', {})
                .done((res) => {
                    alert('<?php _e('Frontend build triggered', 'jamstackpress'); ?>');
                })
                .fail((xhr, status, error) => {
                    alert('<?php _e('There was an error triggering the frontend build', 'jamstackpress'); ?>');
                });
        });
    </script>

<?php
}
?>