<?php

// find'n replace Tnz_tooltips & Tnz_tooltip (as cpt). *Remember to preseve case
// remember to include in functions.php
// var_dump( 'hellow');
// die();
cpt_tnz_tooltip();

function cpt_tnz_tooltip() {
	$labels = array(
		'name'               => _x( 'Tooltips', 'post type general name' ),
		'singular_name'      => _x( 'Tooltip', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Tooltip' ),
		'add_new_item'       => __( 'Add New Tooltip' ),
		'edit_item'          => __( 'Edit Tooltip' ),
		'new_item'           => __( 'New Tooltip' ),
		'all_items'          => __( 'All Tooltips' ),
		'view_item'          => __( 'View Tooltips' ),
		'search_items'       => __( 'Search Tooltips' ),
		'not_found'          => __( 'No Tooltips found' ),
		'not_found_in_trash' => __( 'No Tooltips found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Tooltips'
	);

	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Tooltips',
		'public'        => true,
		'menu_position' => 20,
	 	'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'page-attributes'),
		'has_archive'   => true,
		'hierarchical' 	=> true
	);
	register_post_type( 'tnz_tooltip', $args );
}
add_action( 'init', 'cpt_tnz_tooltip' );

// Set Messages
function cpt_tnz_tooltip_messages( $messages ) {
//http://codex.wordpress.org/Function_Reference/register_post_type

  global $post, $post_ID;

  $messages['tnz_tooltip'] = array(
	0 => '', // Unused. Messages start at index 1.
	1 => sprintf( __('TNZ Tooltip updated.', 'your_text_domain'), esc_url( get_permalink($post_ID) ) ),
	2 => __('TNZ Tooltip updated.', 'your_text_domain'),
	3 => __('TNZ Tooltip deleted.', 'your_text_domain'),
	4 => __('TNZ Tooltip updated.', 'your_text_domain'),
	/* translators: %s: date and time of the revision */
	5 => isset($_GET['revision']) ? sprintf( __('TNZ Tooltip restored to revision from %s', 'your_text_domain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	6 => sprintf( __('TNZ Tooltip published. <a href="%s">View Tnz_tooltip Post</a>', 'your_text_domain'), esc_url( get_permalink($post_ID) ) ),
	7 => __('TNZ Tooltip saved.', 'your_text_domain'),
	8 => sprintf( __('TNZ Tooltip submitted. <a target="_blank" href="%s">Preview Tnz_tooltip Post</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	9 => sprintf( __('TNZ Tooltip scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Tnz_tooltip Post</a>', 'your_text_domain'),
	  // translators: Publish box date format, see http://php.net/date
	  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	10 => sprintf( __('TNZ Tooltip draft updated. <a target="_blank" href="%s">Preview Tnz_tooltip Post</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'cpt_tnz_tooltip_messages' );

?>