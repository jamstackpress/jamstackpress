<!-- Description -->
<p style="margin-bottom: 8px">
    <?php echo $option['description']; ?>
</p>

<!-- Option field -->
<input 
    name="<?php echo $option['id'] ?>" 
    type="email" 
    value="<?php echo get_option($option['id'], ''); ?>" 
/>