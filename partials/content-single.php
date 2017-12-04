<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if (get_the_title()) : ?>

        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

    <?php endif; ?>

    <div class="page-content">

        <?php the_content(); ?>

    </div>

    <?php if (is_single() && (comments_open() || '0' != get_comments_number())) : ?>
        <?php comments_template(); ?>
    <?php endif; ?>

</div>