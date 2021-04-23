<input name="jamstackpress_netlify_status_badge_url" type="text" value="<?php echo get_option('jamstackpress_netlify_status_badge_url', '') ?>" />
<span style="margin-top: 8px; display: block;"><?php _e('For e.g.: https://api.netlify.com/api/v1/badges/xxxxxxxx/deploy-status', 'jamstackpress'); ?></span>

<!-- Netlify status'badge -->
<?php
if ($url = get_option('jamstackpress_netlify_status_badge_url', null)) :
?>
    <div style="align-items: center; display: flex; margin: 28px 0 0px;">
        <span style="margin-right: 20px">
            <strong><?php _e('Last build', 'jamstackpress') ?>:</strong>
        </span>
        
        <img src="<?php echo $url; ?>" />
    </div>
<?php
endif;
?>