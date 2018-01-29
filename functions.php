<?php



// Add scripts and stylesheets
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 300, 300, true );

function startwordpress_scripts() {
	wp_enqueue_style( 'mjstyle', get_template_directory_uri() . '/style.css');
}

add_action( 'wp_enqueue_scripts', 'startwordpress_scripts' );

function add_marko_fields_meta_box() {
	add_meta_box(
		'marko_fields_meta_box', // $id
		'Ratings', // $title
		'show_marko_fields_meta_box', // $callback
		'post', // $screen
		'normal', // $context
		'high' // $priority
	);
}
add_action( 'add_meta_boxes', 'add_marko_fields_meta_box' );

function show_marko_fields_meta_box(){
	global $post;
	$meta = get_post_meta( $post->ID, 'rating', true );
	?>
	<input type="hidden" name="marko_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
	<p>
		<label for="rating">Rating</label>
		<br>
		<input type="number" name="rating"  min="0" max="5" id="rating" class="regular-text" value="<?php echo  isset($meta)?$meta:'4'; ?>" >
	</p>

<?php }

function save_marko_fields_meta( $post_id ) {
	// verify nonce
	if ( !wp_verify_nonce( $_POST['marko_meta_box_nonce'], basename(__FILE__) ) ) {
		return $post_id;
	}
	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	// check permissions
	if ( 'page' === $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	}

	$old = get_post_meta( $post_id, 'rating', true );
	$new = $_POST['rating'];

	if ( is_numeric($new) && $new !== $old ) {
		update_post_meta( $post_id, 'rating', $new );
	} elseif ( '' === $new && $old ) {
		delete_post_meta( $post_id, 'rating', $old );
	}
}

add_action( 'save_post', 'save_marko_fields_meta' );



