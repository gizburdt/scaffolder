<form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="s" class="assistive-text"><?php _e('Search', 'scaffold'); ?></label>
    <input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e('Search', 'scaffold'); ?>" />
    <button type="submit" class="submit" name="submit" id="searchsubmit"><?php _e('Search', 'scaffold'); ?></button>
</form>