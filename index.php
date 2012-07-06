<?php get_header(); ?>

	<div id="content_wrap">
		
		<!-- BEGIN #content -->
		<div id="content">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<h2><?php the_title(); ?></h2>
				
				<div><?php the_content(); ?></div>
				
			<?php endwhile; endif; ?>
			
		</div>
		<!-- END #content -->
		
		
	</div>
	
<?php get_footer(); ?>