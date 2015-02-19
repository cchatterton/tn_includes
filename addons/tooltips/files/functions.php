<?php

function tnz_tooltip_shortcode( $args ) {

 if( is_string( $args ) ) parse_str( $args );
 if( is_array( $args ) ) extract( $args );
	if( !$id ) return;

	// $tnz_tooltip = unserialize( get_transient( 'tnz_tooltip' ) );
	$tnz_tooltip_content = get_post ( $id );

	// $tnz_tooltip[$id]  = '<div id="tnz_tooltip_'.$id.'" class="reveal-tooltip" data-reveal>'."\n";
	// $tnz_tooltip[$id] .= '	'.apply_filters('the_content', $tnz_tooltip_content->post_content )."\n";
	// $tnz_tooltip[$id] .= '	<a class="close-reveal-tooltip">&#215;</a>'."\n";
	// $tnz_tooltip[$id] .= '</div>'."\n";

	// set_transient( 'tnz_tooltip',  serialize( $tnz_tooltip ) , 3600 );

	// return the link
	//$tnz_tooltip_link = '<a href="#" data-reveal-id="tnz_tooltip_'.$id.'">'.$tnz_tooltip_content->post_title.'</a>'."\n";
	$tnz_tooltip_link = '<span id="tnz-tooltip-'.$tnz_tooltip_content->ID.'" data-tooltip aria-haspopup="true" data-options="disable_for_touch:true" class="has-tip" title="'.$tnz_tooltip_content->post_content.'">'.$tnz_tooltip_content->post_title.'</span>'."\n";
	return $tnz_tooltip_link;

}
add_shortcode( 'tooltip' , 'tnz_tooltip_shortcode' );

// function tnz_tooltip_footer() {

//  $args = array(
// 	'posts_per_page'   => -1,
// 	'orderby'          => 'post_date',
// 	'order'            => 'DESC',
// 	'post_type'        => 'tnz_tooltip',
// 	'post_status'      => 'publish',
// 	);
//  $tnz_tooltips = get_posts( $args );
//  echo '<!-- TNZ TOOLTIP START /-->'."\n";

// 	foreach ($tnz_tooltips as $tnz_tooltip) {
// 		$tnz_tooltip_meta = get_post_meta( $tnz_tooltip->ID );
// 		if( $tnz_tooltip_meta['tnz_tooltip_always'][0] == 'true' ) tnz_tooltip_shortcode( 'id='.$tnz_tooltip->ID );
// 	}

// 	$tnz_tooltips = unserialize( get_transient( 'tnz_tooltip' ) );
// 	if( is_array( $tnz_tooltips) ) foreach ( $tnz_tooltips as $tnz_tooltip ) echo $tnz_tooltip;
// 	delete_transient( 'tnz_tooltip' );

// 	echo '<!-- TNZ TOOLTIP END /-->'."\n";

// }
// add_action('wp_footer', 'tnz_tooltip_footer');

?>