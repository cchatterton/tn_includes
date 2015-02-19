<?php

function tnz_modal_shortcode( $args ) {

 if( is_string( $args ) ) parse_str( $args );
 if( is_array( $args ) ) extract( $args );
	if( !$id ) return;

	// Event Manager causes issues here so we need to remove its filters
	remove_filter('the_content', 'em_content');
	remove_filter('the_content', array('EM_Event_Post', 'the_content'));
	remove_filter('the_content', array('EM_Location_Post', 'the_content'));
	remove_filter('the_content', array('EM_Category_Taxonomy', 'the_content'));
	remove_filter('the_content', array('EM_Tag_Taxonomy', 'the_content'));

	$tnz_modal = unserialize( get_transient( 'tnz_modal' ) );
	$tnz_modal_content = get_post ( $id );

	$tnz_modal[$id]  = '<div id="tnz_modal_'.$id.'" class="reveal-modal" data-reveal>'."\n";
	$tnz_modal[$id] .= '	'.apply_filters('the_content', $tnz_modal_content->post_content )."\n";
	$tnz_modal[$id] .= '	<a class="close-reveal-modal">&#215;</a>'."\n";
	$tnz_modal[$id] .= '</div>'."\n";

	// Now we can reinstate Event Manager filters
	add_filter('the_content', 'em_content');
	add_filter('the_content', array('EM_Event_Post','the_content'));
	add_filter('the_content', array('EM_Location_Post','the_content'));
	add_filter('the_content', array('EM_Category_Taxonomy', 'the_content'));
	add_filter('the_content', array('EM_Tag_Taxonomy', 'the_content'));

	set_transient( 'tnz_modal',  serialize( $tnz_modal ) , 3600 );

	// return the link
	$tnz_modal_link = '<a href="#" data-reveal-id="tnz_modal_'.$id.'">'.$tnz_modal_content->post_title.'</a>'."\n";
	return $tnz_modal_link;

}
add_shortcode( 'modal' , 'tnz_modal_shortcode' );

function tnz_modal_footer() {

 $args = array(
	'posts_per_page'   => -1,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'tnz_modal',
	'post_status'      => 'publish',
	);
 $tnz_modals = get_posts( $args );
 echo '<!-- TNZ MODAL START /-->'."\n";

	foreach ($tnz_modals as $tnz_modal) {
		$tnz_modal_meta = get_post_meta( $tnz_modal->ID );
		if( $tnz_modal_meta['tnz_modal_always'][0] == 'true' ) tnz_modal_shortcode( 'id='.$tnz_modal->ID );
	}

	$tnz_modals = unserialize( get_transient( 'tnz_modal' ) );
	if( is_array( $tnz_modals) ) foreach ( $tnz_modals as $tnz_modal ) echo $tnz_modal;
	delete_transient( 'tnz_modal' );

	echo '<!-- TNZ MODAL END /-->'."\n";

}
add_action('wp_footer', 'tnz_modal_footer');

?>