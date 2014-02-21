<?php get_header(); ?>

	<div class="content-wrap">
		<div class="content content-area">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'scaffold' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'search' ); ?>

				<?php endwhile; ?>

				<?php scaffold_paging_nav(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

		</div>
	</div>

	<?php get_sidebar(); ?>
	
<?php get_footer(); ?>
