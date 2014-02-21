<?php get_header(); ?>

	<div class="content-wrap">
		<div class="content content-area">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
							if ( is_day() ) :
								printf( __( 'Day: %s', 'scaffold' ), get_the_date() );
							elseif ( is_month() ) :
								printf( __( 'Month: %s', 'scaffold' ), get_the_date( 'F Y' ) );
							elseif ( is_year() ) :
								printf( __( 'Year: %s', 'scaffold' ), get_the_date( 'Y' ) );
							else :
								_e( 'Archives', 'scaffold' );
							endif;
						?>
					</h1>
				</header>

				<?php while ( have_posts() ) : the_post(); ?>
				
					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>

				<?php scaffold_paging_nav(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>
		</div>

	</div>

<?php get_footer(); ?>