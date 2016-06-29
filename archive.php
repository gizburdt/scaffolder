<?php get_header(); ?>

    <div class="content content-area">

        <?php if (have_posts()) : ?>

            <header class="page-header">
                <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
            </header>

            <?php the_archive_description('<div class="page-description">', '</div>'); ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('content', get_post_format()); ?>

            <?php endwhile; ?>

            <?php the_posts_pagination(); ?>

        <?php else : ?>

            <?php get_template_part('content', 'none'); ?>

        <?php endif; ?>

    </div>

    <?php get_sidebar(); ?>

<?php get_footer(); ?>