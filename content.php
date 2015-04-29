<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h2 class="entry-title"><?php the_title(); ?></h2>
	</header>

	<?php if ( is_search() ) : ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>"><?php _e('Read more', 'scaffold') ?></a>
		</div>

	<?php else : ?>

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'scaffold' ) ); ?>
		</div>

	<?php endif; ?>
</div>
