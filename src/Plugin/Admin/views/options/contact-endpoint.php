<input name="jamstackpress_contact_enabled" type="checkbox" value="true" <?php echo get_option('jamstackpress_contact_enabled', false) ? 'checked' : ''; ?> />
<p style="margin-top: 8px;"><?php _e('Contact endpoint option with reCaptcha verification (this enables also a contact post type and email notificacion)'); ?></p>