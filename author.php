<?php get_header(); ?>

	<div class="content-wrap">
		<div class="content content-area">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
							the_post();
							printf( __( 'All posts by %s', 'scaffold' ), sprintf(
									'<span class="vcard"><a class="url fn n" href="%1$s" rel="me">%2$s</a></span>',
									esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
									get_the_author()
							) );
						?>
					</h1>
				</header>

				<?php rewind_posts(); ?>
				
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile;	?>

			<?php else : ?>
				
				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>
		</div>
	</div>

<?php get_footer(); ?>
