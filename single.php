<?php get_header(); ?>

    <div class="content">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <?php get_template_part('partials/content-single', get_post_type()); ?>

        <?php endwhile; endif; ?>

    </div>

    <?php get_sidebar(); ?>

<?php get_footer(); ?>