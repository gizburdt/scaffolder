<div id="post-<?php the_ID(); ?>" <?php post_class('content-inner'); ?>>
    <header class="entry-header">
        <h2 class="entry-title"><?php the_title(); ?></h2>
    </header>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
        <a href="<?php the_permalink(); ?>"><?php _e('Read more', 'scaffolder') ?></a>
    </div>
</div>