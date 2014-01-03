<?php get_header(); ?>

	<div class="content-wrap">
		
		<!-- #content -->
		<div class="content">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<h2><?php the_title(); ?></h2>
				
				<?php get_template_part( 'content', get_post_format() ); ?>
				
			<?php endwhile; endif; ?>
			
		</div>
		<!-- /content -->
		
		<?php get_sidebar(); ?>
		
	</div>
	
<?php get_footer(); ?>