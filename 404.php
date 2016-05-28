<?php get_header(); ?>

    <div class="content-wrap">
        <div class="content content-area">

            <header class="page-header">
                <h1 class="page-title"><?php _e("Oops! That page can't be found.", 'scaffold'); ?></h1>
            </header>

            <div class="page-content">
                <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'scaffold'); ?></p>

                <?php get_search_form(); ?>
            </div>

        </div>

        <div class="sidebar widget-area">

            <?php get_sidebar(); ?>

        </div>
    </div>

<?php get_footer(); ?>