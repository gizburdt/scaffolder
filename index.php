<?php get_header(); ?>

    <div class="content content-area">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <?php get_template_part('content', get_post_format()); ?>

        <?php endwhile; endif; ?>

    </div>

    <?php get_sidebar(); ?>

<?php get_footer(); ?>