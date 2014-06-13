<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( is_search() ) : ?>
		<header class="entry-header">
			<h2 class="entry-title"><?php the_title(); ?></h2>
		</header>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>
	<?php else : ?>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'scaffold' ) ); ?>
		</div>
	<?php endif; ?>
</div>
