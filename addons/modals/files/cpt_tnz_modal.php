<?php

// find'n replace Tnz_modals & Tnz_modal (as cpt). *Remember to preseve case
// remember to include in functions.php

cpt_tnz_modal();

function cpt_tnz_modal() {

	$labels = array(
		'name'               => _x( 'Modals', 'post type general name' ),
		'singular_name'      => _x( 'Modal', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Modal' ),
		'add_new_item'       => __( 'Add New Modal' ),
		'edit_item'          => __( 'Edit Modal' ),
		'new_item'           => __( 'New Modal' ),
		'all_items'          => __( 'All Modals' ),
		'view_item'          => __( 'View Modals' ),
		'search_items'       => __( 'Search Modals' ),
		'not_found'          => __( 'No Modals found' ),
		'not_found_in_trash' => __( 'No Modals found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Modals'
	);

	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Modals',
		'public'        => true,
		'menu_position' => 20,
	 	'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'page-attributes'),
		'has_archive'   => true,
		'hierarchical' 	=> true
	);
	register_post_type( 'tnz_modal', $args );
}

// Set Messages
function cpt_tnz_modal_messages( $messages ) {
//http://codex.wordpress.org/Function_Reference/register_post_type

  global $post, $post_ID;

  $messages['tnz_modal'] = array(
	0 => '', // Unused. Messages start at index 1.
	1 => sprintf( __('TNZ Modal updated.', 'your_text_domain'), esc_url( get_permalink($post_ID) ) ),
	2 => __('TNZ Modal updated.', 'your_text_domain'),
	3 => __('TNZ Modal deleted.', 'your_text_domain'),
	4 => __('TNZ Modal updated.', 'your_text_domain'),
	/* translators: %s: date and time of the revision */
	5 => isset($_GET['revision']) ? sprintf( __('TNZ Modal restored to revision from %s', 'your_text_domain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	6 => sprintf( __('TNZ Modal published. <a href="%s">View Tnz_modal Post</a>', 'your_text_domain'), esc_url( get_permalink($post_ID) ) ),
	7 => __('TNZ Modal saved.', 'your_text_domain'),
	8 => sprintf( __('TNZ Modal submitted. <a target="_blank" href="%s">Preview Tnz_modal Post</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	9 => sprintf( __('TNZ Modal scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Tnz_modal Post</a>', 'your_text_domain'),
	  // translators: Publish box date format, see http://php.net/date
	  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	10 => sprintf( __('TNZ Modal draft updated. <a target="_blank" href="%s">Preview Tnz_modal Post</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'cpt_tnz_modal_messages' );

?>