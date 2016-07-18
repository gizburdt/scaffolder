<div id="post-<?php the_ID(); ?>" <?php post_class('content-inner'); ?>>

    <?php if (get_the_title()) : ?>

        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

    <?php endif; ?>

    <div class="page-content">

        <?php the_content(); ?>

    </div>
</div>