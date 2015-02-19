<?php
/*
Plugin Name: TN Includes
Plugin URI: http://techn.com.au/plugins/
Version: 0.1
Author: TECHN
Author URI: http://techn.com.au
Description:
License: GPL2
------------------------------------------------------------------------

Copyright 2013. This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

*/

// last updated: 07/02/2014

$path = plugin_dir_path( __FILE__ );

$includes = array(
	array( 'file' => 'functions.php',      'dir' => 'core' ),
	array( 'file' => 'admin.php',  								'dir' => 'core' ),
	// array( 'file' => 'init.php',  									'dir' => 'cmb' ),
	array( 'file' => 'cpt.php',  										'dir' => 'class' ),
);

foreach ($includes as $args )  {
	is_array( $args ) ? extract( $args ) : parse_str( $args );
	require_once( $path . $dir . '/' . $file );
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
function cmb_initialize_cmb_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) ) require_once 'cmb/init.php';
}
?>