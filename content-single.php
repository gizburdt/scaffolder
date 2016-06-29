<div id="post-<?php the_ID(); ?>" <?php post_class('content-inner'); ?>>
    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <div class="page-content">

        <?php the_content(); ?>

    </div>
</div>