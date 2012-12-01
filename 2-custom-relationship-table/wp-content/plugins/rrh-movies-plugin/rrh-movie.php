<?php

/*
Plugin Name: Movie Database
Description: Registers People and Movies and provides a way to relate them together
*/

add_action('init','rrh_movie_register');
function rrh_movie_register() {

  $args = array(
    'labels' => array(
        'name' => 'Movies',
        'singular_name' => 'Movie',
        'add_new' => 'Add Movie',
        'add_new_item' => 'Add Movie',
        'edit_item' => 'Edit Movie',
        'new_item' => 'New Movie',
        'all_items' => 'All Movies',
        'view_item' => 'View Movie',
        'search_items' => 'Search Movies',
        'not_found' =>  'No movies found',
        'not_found_in_trash' => 'No movies found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Movies',
    ),
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'movie'),
    'capability_type' => 'post',
    'has_archive' => 'movies', 
    'menu_position' => 6
  ); 
  register_post_type('rrh_movie',$args);
  
  $args = array(
    'labels' => array(
        'name' => 'People',
        'singular_name' => 'Person',
        'add_new' => 'Add Person',
        'add_new_item' => 'Add Person',
        'edit_item' => 'Edit Person',
        'new_item' => 'New Person',
        'all_items' => 'All People',
        'view_item' => 'View Person',
        'search_items' => 'Search People',
        'not_found' =>  'No people found',
        'not_found_in_trash' => 'No people found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'People',
    ),
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'person'),
    'capability_type' => 'post',
    'has_archive' => 'schedule', 
    'menu_position' => 5
  ); 
  register_post_type('rrh_person',$args);  
  
}

add_filter('cmb_meta_boxes', 'rrh_movie_meta_boxes');
function rrh_movie_meta_boxes($meta_boxes) {
    $meta_boxes[] = array(
		'id' => 'rrh_person_data',
		'title' => 'Person Information',
		'pages' => array('rrh_person'), // post type
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
        ),
    );
}

function rrh_movie_connection_types() {
	p2p_register_connection_type(
	    array(
	       'name' => 'rrh_person_to_movie',
	       'from' => 'rrh_person',
	       'to' => 'rrh_movie',
	       'fields' => array(
	           'role' => array( 
	               'title' => 'Role',
	               'type' => 'select',
        			'values' => array( 'Director', 'Writer', 'Lead Actor', 'Lead Actress', 'Supporting Cast', 'Producer', 'Editor' )
               ),
		       'character' => array(
   	 		       'title' => 'Character',
			       'type' => 'text'
			   )
            ),   
		)
	);
}
add_action( 'p2p_init', 'rrh_movie_connection_types' );

add_action('admin_menu', 'rrh_movie_rearrange_menu');
function rrh_movie_rearrange_menu() {
	global $menu;
	$menu[9] = $menu[5];
	$menu[8] = $menu[20];
	unset($menu[5]);
	unset($menu[20]);	
}

add_action( 'admin_head', 'rrh_movie_icons' );
function rrh_movie_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-rrh_person .wp-menu-image {
            background: url(<?php echo plugin_dir_url(__FILE__); ?>/img/icon-16-rrh_person.png) no-repeat 6px -17px !important;
        }
        #menu-posts-rrh_person:hover .wp-menu-image, #menu-posts-rrh_person.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px!important;
        }
        div.icon32-posts-rrh_person {
            background: url(<?php echo plugin_dir_url(__FILE__); ?>/img/icon-32-rrh_person.png) top left no-repeat !important;
        }        
        #menu-posts-rrh_movie .wp-menu-image {
            background: url(<?php echo plugin_dir_url(__FILE__); ?>/img/icon-16-rrh_movie.png) no-repeat 6px -17px !important;
        }
        #menu-posts-rrh_movie:hover .wp-menu-image, #menu-posts-rrh_movie.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px!important;
        }        
        div.icon32-posts-rrh_movie {
            background: url(<?php echo plugin_dir_url(__FILE__); ?>/img/icon-32-rrh_movie.png) top left no-repeat !important;
        }
        div#edit-slug-box {display: none;}
        span#last-edit {visibility: hidden}
        span#timestamp {display: none;}
    </style>
<?php }

add_filter('posts_orderby', 'rrh_movie_orderby' );
function rrh_movie_orderby( $orderby )
{

	if(is_post_type_archive('rrh_person') || (is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'rrh_person')) {
			$orderby = " substring(post_title FROM instr(post_title,' ')) ASC ";
	}
	if(is_post_type_archive('rrh_movie') || (is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'rrh_movie')) {
			$orderby = " post_title ASC ";
	}	
 	return $orderby;
}