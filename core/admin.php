<?php

class tn_includes {

	private $key = 'tn_includes';
	protected $option_metabox = array();
	protected $title = '';
	protected $options_pages = array();

	public function __construct() {
		$this->title = __( 'Includes', 'theme_textdomain' );
	}

	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) ); //create tab pages
	}

	public function init() {
		$option_tabs = self::option_fields();
		foreach ($option_tabs as $index => $option_tab) register_setting( $option_tab['id'], $option_tab['id'] );
	}

	public function add_options_page() {
		$option_tabs = self::option_fields();
		foreach ($option_tabs as $index => $option_tab) {
			if ( $index == 0) {
				$this->options_pages[] = add_menu_page( $this->title, $this->title, 'manage_options', $option_tab['id'], array( $this, 'admin_page_display' ) ); //Link admin menu to first tab
				add_submenu_page( $option_tabs[0]['id'], $this->title, $option_tab['title'], 'manage_options', $option_tab['id'], array( $this, 'admin_page_display' ) ); //Duplicate menu link for first submenu page
			} else {
				$this->options_pages[] = add_submenu_page( $option_tabs[0]['id'], $this->title, $option_tab['title'], 'manage_options', $option_tab['id'], array( $this, 'admin_page_display' ) );
			}
		}
	}

	public function admin_page_display() {
		$option_tabs = self::option_fields(); //get all option tabs
		$tab_forms = array();
		echo '<div class="wrap cmb_options_page '.$this->key.'">'."\n";
		echo '	<h2>'.esc_html( get_admin_page_title() ).'</h2>'."\n";
		echo '	<!-- Options Page Nav Tabs -->'."\n";
		echo '	<h2 class="nav-tab-wrapper">'."\n";
		foreach ($option_tabs as $option_tab) {
			$tab_slug = $option_tab['id'];
			$nav_class = 'nav-tab';
			if ( $tab_slug == $_GET['page'] ) {
				$nav_class .= ' nav-tab-active'; //add active class to current tab
				$tab_forms[] = $option_tab; //add current tab to forms to be rendered
			}
			echo '<a class="'.$nav_class.'" href="'.menu_page_url( $tab_slug, false ).'">'.esc_attr__($option_tab['title']).'</a>'."\n";
		}
		echo '	</h2>'."\n";
		echo '	<!-- End of Nav Tabs -->'."\n";

		foreach ($tab_forms as $tab_form) { //render all tab forms (normaly just 1 form)
			echo '	<div id="'.esc_attr__($tab_form['id']).'" class="group">'."\n";
			if( !$tab_form["fields"] ) echo $tab_form["content"];
			cmb_metabox_form( $tab_form, $tab_form['id'] );
			echo '	</div>'."\n";
		}
		echo '</div>'."\n";

	}
	public function option_fields() {

		// Only need to initiate the array once per page-load
		if ( ! empty( $this->option_metabox ) ) return $this->option_metabox;

		// CPT tab
		$this->option_metabox[] = array(
			'id'         => 'tni_cpt', //id used as tab page slug, must be unique
			'title'      => 'CPTs',
			'show_on'    => array( 'key' => 'options-page', 'value' => array( 'tni_cpt' ), ), //value must be same as id
			'show_names' => true,
			'fields'     => array(
				// array('name' => 'title', 'desc' => 'sample title field', 'id' => 'tni_sample_title', 'type' => 'title'),
				// array('name' => 'file', 'desc' => 'sample file field', 'id' => 'tni_sample_file', 'default' => '', 'type' => 'file' ),
  		// 		array('name' => 'text', 'desc' => 'sample text field', 'id' => 'tni_sample_text', 'type' => 'text'),
				// array('name' => 'textarea_small', 'desc' => 'sample textarea_small', 'id' => 'tni_sample_textarea_small', 'default' => '', 'type' => 'textarea_small'),
				// array('name' => 'textarea', 'desc' => 'sample textarea', 'id' => 'tni_sample_textarea', 'default' => '', 'type' => 'textarea'),
				// array('name' => 'colorpicker', 'desc' => 'sample colorpicker.', 'id' => 'tni_sample_colorpicker', 'default' => '', 'type' => 'colorpicker'),
  				array('name' => 'CPT arguments', 'desc' => 'each line is a CPT as single,plural', 'id' => 'tni_cpt_args', 'default' => '', 'type' => 'textarea_small'),
			)
		);

		$this->option_metabox[] = array(
			'id'         => 'tni_meta', //id used as tab page slug, must be unique
			'title'      => 'Post Meta',
			'show_on'    => array( 'key' => 'options-page', 'value' => array( 'tni_meta' ), ), //value must be same as id
			'show_names' => true,
			'fields'     => array(
  				array('name' => 'Post Meta arguments', 'desc' => 'Approach/Syntax TBA', 'id' => 'tni_meta_args', 'default' => '', 'type' => 'textarea_small'),
			)
		);

		$this->option_metabox[] = array(
			'id'         => 'tni_tax', //id used as tab page slug, must be unique
			'title'      => 'TAXs',
			'show_on'    => array( 'key' => 'options-page', 'value' => array( 'tni_tax' ), ), //value must be same as id
			'show_names' => true,
			'fields'     => array(
  				array('name' => 'Tax arguments', 'desc' => 'Approach/Syntax TBA', 'id' => 'tni_tax_args', 'default' => '', 'type' => 'textarea_small'),
			)
		);

		$this->option_metabox[] = array(
			'id'         => 'tni_terms', //id used as tab page slug, must be unique
			'title'      => 'Term Meta',
			'show_on'    => array( 'key' => 'options-page', 'value' => array( 'tni_terms' ), ), //value must be same as id
			'show_names' => true,
			'fields'     => array(
  				array('name' => 'Term Meta arguments', 'desc' => 'Approach/Syntax TBA', 'id' => 'tni_term_args', 'default' => '', 'type' => 'textarea_small'),
			)
		);

		$this->option_metabox[] = array(
			'id'         	=> 'tni_addons',
			'title'      	=> 'Addons',
			'show_on'    	=> array( 'key' => 'options-page', 'value' => array( 'tni_addons' ), ),
			'show_names' 	=> true,
			'content'		=> tni_addons_page()
		);

		$this->option_metabox[] = array(
			'id'         => 'tni_css', //id used as tab page slug, must be unique
			'title'      => 'CSS',
			'show_on'    => array( 'key' => 'options-page', 'value' => array( 'tni_css' ), ), //value must be same as id
			'show_names' => true,
			'fields'     => array(
				array('name' => 'Admin CSS', 'id' => 'tni_css_admin', 'default' => '', 'type' => 'textarea'),
				array('name' => 'Web CSS', 'id' => 'tni_css_web', 'default' => '', 'type' => 'textarea'),
			)
		);

		//insert extra tabs here
		return $this->option_metabox;
	}

	public function get_option_key($field_id) {
	 $option_tabs = $this->option_fields();
	 foreach ($option_tabs as $option_tab) { //search all tabs
	  foreach ($option_tab['fields'] as $field) { //search all fields
	   if ($field['id'] == $field_id) {
		return $option_tab['id'];
	   }
	  }
	 }
	 return $this->key; //return default key if field id not found
	}

	public function __get( $field ) {

		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'fields', 'title', 'options_pages' ), true ) ) return $this->{$field};
		if ( 'option_metabox' === $field ) return $this->option_fields();
		throw new Exception( 'Invalid property: ' . $field );
	}

}

// Get it started
$tn_includes = new tn_includes();
$tn_includes->hooks();

function tn_includes_get_option( $key = '' ) {
    global $tn_includes;
    return cmb_get_option( $tn_includes->key, $key );
}

add_action( 'init', 'tni_addons_managment' );

function tni_addons_managment() {
	$path = plugin_dir_path( __FILE__ );
	$addon_dir = substr( $path, 0, -5 ).'addons/';
	$options = unserialize( get_option( 'tni_addons_status' ) );
	// var_dump( $options );
	if($options == flase) add_option( 'tni_addons_status', 'new', '', 'yes' );
	if( !is_array($options) ) $options = array();
	$addons = scandir( $addon_dir = substr( plugin_dir_path( __FILE__ ), 0, -5 ).'addons/' );
	foreach($addons as $addon) {
		if( strpos( $addon, '.') === false ) {
			// var_dump('x'.$addon_dir);
			$readme = file_get_contents( $addon_dir.$addon.'/readme.txt' );
			// var_dump($addon_dir.$addon.'/readme.txt');
			if( strlen( $readme ) > 0 && $options[$addon] == true ) {
						// var_dump($addon);
				$functions = file_get_contents( $addon_dir.$addon.'/functions.php' );
				if( strlen( $functions ) > 0 ) require_once( $addon_dir.$addon.'/functions.php' );
			}
		// $addon_dir = substr( plugin_dir_path( __FILE__ ), 0, -5 ).'addons/';
		}
	}
}
add_action( 'admin_menu', 'tni_addons_menu' );

function tni_addons_page(){

 // $content = '  <h1>Theme Addons</h1>'."\n";

 $options = unserialize( get_option( 'tni_addons_status' ) );
 if($options == flase) add_option( 'tni_addons_status', 'new', '', 'yes' );
 if( !is_array($options) ) $options = array();

 $content .= '<style>'."\n";
 $content .= '	#tni_addons {margin-top: 2rem;}'."\n";
 $content .= ' .tni-addon-tile {background-attachment: scroll; background-color: #0074a2; background-image: none; background-origin: padding-box; background-position: 0 0; background-repeat: repeat; background-size: auto auto; border-radius: 5px; color: #fff; font-size: 1.5rem; font-weight: bold; height: 2.75rem; margin: 1rem 1rem 1rem 0; padding-top: 1.125rem; text-align: center; text-shadow: 1px 4px 6px #0074a2, 1px 1px 0 #000, 1px 4px 6px #0074a2; text-transform: lowercase; width: 4rem;}'."\n";
 $content .= ' .tni-addon-wrapper h1 {margin-bottom: 0;}'."\n";
 $content .= ' .tni-addon-wrapper form {margin: 1rem 0;max-width:800px;}'."\n";
 $content .= ' .tni-addon-wrapper .active {background: none repeat scroll 0 0 green; border-radius: 10px; clear: both; color: #fff; display: inline-block; font-size: 0.625rem; font-weight: normal; left: 9px; padding: 0.025rem 0.5rem 0.2rem; position: relative; top: -5px; }'."\n";
 $content .= '	.tni-addon-wrapper > div {border-bottom: 1px solid rgba(0,0,0,0.05);}'."\n";
 $content .= '</style>'."\n";

 $addons = scandir( $dir = substr( plugin_dir_path( __FILE__ ), 0, -5 ).'addons/' );
 foreach($addons as $addon) {
  if( strpos( $addon, '.') === false ) {
   $readme = file_get_contents( $dir.$addon.'/readme.txt' );
   if( strlen( $readme ) > 0 ) {

	if( $_GET['tni-addon-'.$addon] == 'activate' ) $options[$addon] = true;
	if( !$options[$addon] || $_GET['tni-addon-'.$addon] == 'deactivate' ) $options[$addon] = false;

	$content .= '<div class="tni-addon-wrapper" style="display:table-row;">'."\n";
	$content .= ' <div style="display: table-cell; vertical-align: top;">'."\n";
	$content .= '  <div class="tni-addon-tile" >'.substr( $addon, 0,2 ).'</div>'."\n";
	$content .= ' </div>'."\n";
	$content .= ' <div style="display: table-cell; max-width: 800px; width:100%;">'."\n";
	$content .= '  <h1>'.$addon;
	if( $options[$addon] == true ) $content .= '<span class="active">&#10004; active</span>'."\n";
	$content .= '</h1>'."\n";
	$content .= $readme;
	$content .= tni_addon_activate( $addon );
	$content .= ' </div>'."\n";
	$content .= '</div>'."\n";
   }
  }
 }
 update_option( 'tni_addons_status', serialize( $options ) );
 return $content;
}

function tni_addon_activate( $addon ) {
 $content .= '<form id="tni-addon-'.$addon.'" action="/uiop/wp-admin/admin.php" method="get">'."\n";
 $content .= ' <input type="hidden" id="page" name="page" value="tni_addons">'."\n";
 $content .= ' <input class="button" type="submit" name="tni-addon-'.$addon.'" value="activate">'."\n";
 $content .= ' <input class="button" type="submit" name="tni-addon-'.$addon.'" value="deactivate">'."\n";
 $content .= '</form>'."\n";
 return $content;
}


?>