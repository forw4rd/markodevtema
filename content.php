
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		if ( has_post_thumbnail() ) {
            the_post_thumbnail();
            }
    ?>

	<header class="entry-header">
		<?php
				the_title( '<h1 class="entry-title">', '</h1>' );
		?>
	</header>

	<?php
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

	<footer class="entry-footer">
        Rating:
		<?php $meta = get_post_meta( $post->ID, 'rating', true ); echo $meta; ?>
		<?php edit_post_link( __( 'Edit', 'markodevtema' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article>
