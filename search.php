<?php get_header(); ?>

    <div class="content">

        <?php if (have_posts()) : ?>

            <header class="page-header">
                <h1 class="page-title">
                    <?php printf(__('Search Results for: %s', 'scaffolder'), '<span>'.get_search_query().'</span>'); ?>
                </h1>
            </header>

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('partials/content', 'search'); ?>

            <?php endwhile; ?>

            <?php the_posts_pagination(); ?>

        <?php else : ?>

            <?php get_template_part('partials/not-found'); ?>

        <?php endif; ?>

    </div>

    <?php get_sidebar(); ?>

<?php get_footer(); ?>