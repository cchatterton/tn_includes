<?php // last updated 19/07/2014

// 1. find'n replace Tnz_tooltips & Tnz_tooltip (as cpt). *Remember to preseve case
// 2. add to the $includes array() in functions.php
// 3. add custom fields to tnz_tooltip_metabox_content

function tnz_tooltip_metabox() {
	add_meta_box( 'cpt_tnz_tooltip_box', __( 'Tooltip Shortcode', '' ), 'tnz_tooltip_metabox_content', 'tnz_tooltip', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'tnz_tooltip_metabox' );

function tnz_tooltip_metabox_content( $post ) {

	global $post;
	echo '<pre>[tooltip id='.$post->ID.']</pre>'."\n";
	echo '<div style="display: block; font-family: courier new; margin-bottom: 1rem; max-width: 300px;">';
	// echo '&lt;a data-reveal-id="tnz_tooltip_'.$post->ID.'" href="#"&gt;'.$post->post_title.'&lt;/a&gt;';
	echo '&lt;span id = "tnz-tooltip-'.$post->ID.'" data-tooltip aria-haspopup = "true" data-options = "disable_for_touch:true" class = "has-tip" title = "'.$post->post_content.'">'.$post->post_title.'&lt;/span&gt;';

	echo '</div>'."\n";

	if( !is_array( $tnz_tooltip_fields) ) $tnz_tooltip_fields = array();
	//wp_nonce_field( plugin_basename( __FILE__ ), 'tnz_tooltip_metabox_content_nonce' );

	// custom fields here! new line for each field
	// example #1 array_push( $tnz_tooltip_fields, tn_new_meta( 'title=title2&name=name2&size=50%&type=text' ) );
	// example #2 array_push( $tnz_tooltip_fields, tn_new_meta( array( 'title' => 'title3', 'type' => 'text' ) ) );
	$args = 'title=Add Tooltip to Footer&field_name=tnz_tooltip_always&size=100%&type=checkbox';
	// if( function_exists( 'bb_new_field' ) )	array_push( $tnz_tooltip_fields, bb_new_field( $args ) );
	// if( function_exists( 'tn_new_field' ) )	array_push( $tnz_tooltip_fields, tn_new_field( $args ) );
	set_transient( 'tnz_tooltip_fields', serialize( $tnz_tooltip_fields ), 3600 );
}

function tnz_tooltip_metabox_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	//if ( !wp_verify_nonce( $_POST['tnz_tooltip_metabox_content_nonce'], plugin_basename( __FILE__ ) ) ) 	return;
	if ( 'page' == $_POST['post_type'] && ( !current_user_can( 'edit_page', $post_id ) || !current_user_can( 'edit_post', $post_id ) ) ) return;
	$tnz_tooltip_fields = unserialize( get_transient( 'tnz_tooltip_fields' ) );
	foreach( $tnz_tooltip_fields as $meta_field ) update_post_meta( $post_id, $meta_field, sanitize_text_field( $_POST[$meta_field] ) );
}
add_action( 'save_post', 'tnz_tooltip_metabox_save' );

?>