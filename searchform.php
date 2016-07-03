<form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="s" class="assistive-text"><?php _e('Search', 'scaffolder'); ?></label>
    <input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e('Search', 'scaffolder'); ?>" />
    <button type="submit" class="submit" name="submit" id="searchsubmit"><?php _e('Search', 'scaffolder'); ?></button>
</form>