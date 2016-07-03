<?php get_header(); ?>

    <div class="content content-area">

        <header class="page-header">
            <h1 class="page-title"><?php _e("Oops! That page can't be found.", 'scaffolder'); ?></h1>
        </header>

        <div class="page-content">
            <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'scaffolder'); ?></p>

            <?php get_search_form(); ?>
        </div>

    </div>

    <?php get_sidebar(); ?>

<?php get_footer(); ?>