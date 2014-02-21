<?php get_header(); ?>

	<div class="content-wrap">
		<div class="content content-area">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<?php get_template_part( 'content', get_post_format() ); ?>
				
			<?php endwhile; endif; ?>
			
		</div>
		<!-- /content -->
		
		<?php get_sidebar(); ?>
		
	</div>
	
<?php get_footer(); ?>