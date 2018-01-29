<?php
/**
 * The main template file
 * @package MarkoDevTema
 *
 */

get_header();
?>

		<main id="main" class="site-main" role="main">

			<?php

			$args = array(
				'posts_per_page' => 1,
				'post_type' => 'post',
				'paged' => get_query_var( 'paged' )? get_query_var( 'paged' ): 1,
				'orderby' => 'meta_value',
				'order' => 'DESC',
				'meta_key'=> 'rating',
				);
			// Custom query.
				$query = new WP_Query( $args );
				$temp_query = $wp_query;
				$wp_query   = NULL;
				$wp_query   = $query;
			// Check that we have query results.
			if ( $query->have_posts() )  : ?>


					<header>
						<h1 class="page-title">Jednostavna tema</h1>
					</header>

				<?php

				while ( $query->have_posts() ) :  $query->the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content',  get_post_format() );

					// End the loop.
				endwhile;
				the_posts_pagination( array(
					'prev_text'          => __( '<<', 'markodevtema' ),
					'next_text'          => __( '>>', 'markodevtema' ),
					'before_page_number' => '<span class="meta-nav">' . __( 'Page', 'markodevtema' ) . ' </span>',
				) );
				wp_reset_postdata();
				// Previous/next page navigation.


			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'content', 'none' );

			endif;
			?>

		</main><!-- .site-main -->

<?php get_footer(); ?>