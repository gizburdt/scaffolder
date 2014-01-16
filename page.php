<?php get_header(); ?>

	<div class="content-wrap">
		<div class="content">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

		</div>
	</div>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
