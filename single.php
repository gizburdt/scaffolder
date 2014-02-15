<?php get_header(); ?>

	<div class="content-wrap">
		<div class="content content-area">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; ?>

		</div>

		<?php get_sidebar(); ?>
	</div>


<?php get_footer(); ?>