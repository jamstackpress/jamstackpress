<input name="jamstackpress_full_slug_field" type="checkbox" value="true" <?php echo get_option('jamstackpress_full_slug_field', false) ? 'checked' : ''; ?> />
<p style="margin-top: 8px"><?php _e('Include a routes field in the REST api, that contains the post slug, and the frontend post url', 'jamstackpress'); ?></p>