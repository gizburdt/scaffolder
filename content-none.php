<div class="content-inner no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php _e('Nothing Found', 'scaffolder'); ?></h1>
    </header>

    <div class="page-content">

        <?php if (is_search()) : ?>
            <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'scaffolder'); ?></p>
        <?php else : ?>
            <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'scaffolder'); ?></p>
        <?php endif; ?>

        <?php get_search_form(); ?>

    </div>
</div>