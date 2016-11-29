<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if (get_the_title()) : ?>

        <header class="entry-header">
            <h2 class="entry-title"><?php the_title(); ?></h2>
        </header>

    <?php endif; ?>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
        <a href="<?php the_permalink(); ?>"><?php _e('Read more', 'scaffolder') ?></a>
    </div>
</div>