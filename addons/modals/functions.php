<?php
/*
Plugin Name: TN Zurb Modals
Plugin URI: http://techn.com.au/plugins/
Version: 0.1
Author: TECHN
Author URI: http://techn.com.au
Description:
License: GPL2
------------------------------------------------------------------------

Copyright 2013. This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

*/

// last updated: 18/07/2014

$path = plugin_dir_path( __FILE__ );

$includes = array(
	array( 'file' => 'functions.php',      'dir' => 'files' ),
	array( 'file' => 'cpt_tnz_modal.php',  'dir' => 'files' ),
	array( 'file' => 'meta_tnz_modal.php', 'dir' => 'files' ),
);

foreach ($includes as $args )  {
	is_array( $args ) ? extract( $args ) : parse_str( $args );
	require_once( $path . $dir . '/' . $file );
}


?>