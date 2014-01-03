<?php get_header(); ?>

	<div class="content-wrap">
		<div class="content">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php scaffold_post_nav(); ?>

			<?php
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; ?>

		</div>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>