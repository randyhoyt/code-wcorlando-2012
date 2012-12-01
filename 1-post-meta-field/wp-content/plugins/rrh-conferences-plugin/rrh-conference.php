<?php

/*
Plugin Name: Conference Site
Description: Registers Speakers and Talks and provides a way to relate them together
*/

add_action('init','rrh_conference_register');
function rrh_conference_register() {

  $args = array(
    'labels' => array(
        'name' => 'Speakers',
        'singular_name' => 'Speaker',
        'add_new' => 'Add Speaker',
        'add_new_item' => 'Add Speaker',
        'edit_item' => 'Edit Speaker',
        'new_item' => 'New Speaker',
        'all_items' => 'All Speakers',
        'view_item' => 'View Speaker',
        'search_items' => 'Search Speakers',
        'not_found' =>  'No speakers found',
        'not_found_in_trash' => 'No speakers found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Speakers',
    ),
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'speaker'),
    'capability_type' => 'post',
    'has_archive' => 'speakers', 
    'supports' => array( 'title','editor','custom-fields' ),
    'menu_position' => 7
  ); 
  register_post_type('rrh_speaker',$args);
  
  $args = array(
    'labels' => array(
        'name' => 'Talks',
        'singular_name' => 'Talk',
        'add_new' => 'Add Talk',
        'add_new_item' => 'Add Talk',
        'edit_item' => 'Edit Talk',
        'new_item' => 'New Talk',
        'all_items' => 'All Talks',
        'view_item' => 'View Talk',
        'search_items' => 'Search Talks',
        'not_found' =>  'No talks found',
        'not_found_in_trash' => 'No talks found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Talks',
    ),
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'schedule'),
    'capability_type' => 'post',
    'has_archive' => 'schedule', 
    'supports' => array( 'title','editor', 'custom-fields' ),
    'menu_position' => 8
  ); 
  register_post_type('rrh_talk',$args);  
  
}

add_action('init','rrh_conference_init_cmb_meta_boxes',10000);
function rrh_conference_init_cmb_meta_boxes() {
	if (!class_exists('cmb_Meta_Box')) { require_once('metaboxes/init.php'); }
}
add_filter('cmb_meta_boxes', 'rrh_conference_meta_boxes');
function rrh_conference_meta_boxes($meta_boxes) {
    $meta_boxes[] = array(
		'id' => 'rrh_speaker_data',
		'title' => 'Speaker Information',
		'pages' => array('rrh_speaker'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'First Name',
				'id' => 'name_first',
				'type' => 'text'
			),
			array(
				'name' => 'Last Name',
				'id' => 'name_last',
				'type' => 'text'
			),			
			array(
				'name' => 'Twitter',
				'id' => 'twitter',
				'type' => 'text'
			),
			array(
				'name' => 'Image URL',
				'id' => 'img',
				'type' => 'text'
			),			
			array(
				'name' => 'Job Title',
				'id' => 'job_title',
				'type' => 'text'
			),			
			array(
				'name' => 'Company',
				'id' => 'company',
				'type' => 'text'
			),
			array(
				'name' => 'Company URL',
				'id' => 'company_url',
				'type' => 'text'
			),
        ),
    );
    $speakers = query_posts( 'posts_per_page=-1&post_type=rrh_speaker');
    $options[] = array('name' => '&#8212; Select &#8212;', 'value' => '');
    foreach ($speakers as $speaker) {
        $options[] = array('name' => $speaker->post_title, 'value' => $speaker->ID); 
        $options_multi[$speaker->ID] = $speaker->post_title;
    }
    wp_reset_query();
    $meta_boxes[] = array(
		'id' => 'rrh_talk_data',
		'title' => 'Talk Information',
		'pages' => array('rrh_talk'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
            array(
				'name' => 'Speaker',
				'id' => 'speaker',
				'type' => 'select', // change to 'multiselect' for checkboxes
				'options' => $options // change to $options_multi for checkboxes
			),
        ),
    );    
	return $meta_boxes;
}


add_action('admin_menu', 'rrh_conference_rearrange_menu');
function rrh_conference_rearrange_menu() {
	global $menu;
	$menu[9] = $menu[5];
	$menu[5] = $menu[20];
	unset($menu[20]);
}

add_action( 'admin_head', 'rrh_conference_icons' );
function rrh_conference_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-rrh_speaker .wp-menu-image {
            background: url(<?php echo plugin_dir_url(__FILE__); ?>/img/icon-16-rrh_speaker.png) no-repeat 6px -17px !important;
        }
        #menu-posts-rrh_speaker:hover .wp-menu-image, #menu-posts-rrh_speaker.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px!important;
        }
        div.icon32-posts-rrh_speaker {
            background: url(<?php echo plugin_dir_url(__FILE__); ?>/img/icon-32-rrh_speaker.png) top left no-repeat !important;
        }        
        #menu-posts-rrh_talk .wp-menu-image {
            background: url(<?php echo plugin_dir_url(__FILE__); ?>/img/icon-16-rrh_talk.png) no-repeat 6px -17px !important;
        }
        #menu-posts-rrh_talk:hover .wp-menu-image, #menu-posts-rrh_talk.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px!important;
        }        
        div.icon32-posts-rrh_talk {
            background: url(<?php echo plugin_dir_url(__FILE__); ?>/img/icon-32-rrh_talk.png) top left no-repeat !important;
        }
    </style>
<?php }

add_filter('posts_orderby', 'rrh_conference_orderby' );
function rrh_conference_orderby( $orderby )
{

	if(is_post_type_archive('rrh_speaker') || (is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'rrh_speaker')) {
			$orderby = " substring(post_title FROM instr(post_title,' ')) ASC ";
	}
	if(is_post_type_archive('rrh_talk') || (is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'rrh_talk')) {
			$orderby = " post_title ASC ";
	}	
 	return $orderby;
}