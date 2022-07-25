<!-- Description -->
<p style="margin-bottom: 8px">
    <?php echo $option['description']; ?>
</p>

<!-- Option field -->
<textarea
    rows="5"
    name="<?php echo $option['id'] ?>" 
    value="<?php echo get_option($option['id'], ''); ?>" 
>
    <?php echo get_option($option['id'], ''); ?>
</textarea>