<?php
/**
 * IKONIC functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package IKONIC
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ikonic_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on IKONIC, use a find and replace
		* to change 'ikonic' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'ikonic', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'ikonic' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'ikonic_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'ikonic_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ikonic_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ikonic_content_width', 640 );
}
add_action( 'after_setup_theme', 'ikonic_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ikonic_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ikonic' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ikonic' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ikonic_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ikonic_scripts() {
	wp_enqueue_style( 'ikonic-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'ikonic-style', 'rtl', 'replace' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'ikonic-jquery','https://code.jquery.com/jquery-3.5.0.slim.min.js', array(), false, true );

	wp_enqueue_script( 'ikonic-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ikonic_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



/**
 * Custom Code Starts From Here.
 */ 


// Archive Page Pagination Code which Implements on Archive.php

function project_type_posts_per_page( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
       return;
    }
	if( $query->is_category()) {
        $query->set( 'posts_per_page', 6 );
    }

	if (is_tax( 'project_type' )) { 
		$query->set( 'posts_per_page', 6 );
	}
}
add_filter( 'pre_get_posts', 'project_type_posts_per_page' );

/**
 * Checks If user IP starts from 77.29.
 */ 


add_action('init', 'redirect_user_by_ip');

function redirect_user_by_ip() {
  // Get the user's IP address
  $user_ip = $_SERVER['REMOTE_ADDR'];

  // Check if the IP address starts with "77.29"
  if (strpos($user_ip, '77.29') === 0) {
    // Redirect the user to a different website or page
    wp_redirect('URl Where You Want TO Redirect');
    exit;
  }
}


/**
 * Creating A Custom Post Type and Taxonomy.
 */ 


add_action('init', 'register_projects_post_type');

function register_projects_post_type() {
    $labels = array(
        'name'               => 'Projects',
        'singular_name'      => 'Project',
        'menu_name'          => 'Projects',
        'name_admin_bar'     => 'Project',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Project',
        'edit_item'          => 'Edit Project',
        'new_item'           => 'New Project',
        'view_item'          => 'View Project',
        'all_items'          => 'All Projects',
        'search_items'       => 'Search Projects',
        'parent_item_colon'  => 'Parent Projects:',
        'not_found'          => 'No projects found.',
        'not_found_in_trash' => 'No projects found in Trash.'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'projects' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => null,
		'menu_icon'             => 'dashicons-admin-site',
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
        'has_archive'           => true,
    );

    register_post_type( 'projects', $args );

    // Register taxonomy 'project_type' for the 'projects' post type
    register_taxonomy('project_type','projects',array(
            'label' => 'Project Types',
            'rewrite' => array( 'slug' => 'project-type' ),
            'hierarchical' => true,
        )
    );
}



/**
 * Ajax Endpoint For Calling last 6 or 3 Posts For Architecture Term.
 */ 


// Register Ajax endpoint
add_action( 'wp_ajax_nopriv_fetch_projects', 'fetch_projects' );
add_action( 'wp_ajax_fetch_projects', 'fetch_projects' );

function fetch_projects() {
    // Check if the user is logged in
    $is_logged_in = is_user_logged_in();

    // Set the number of projects to retrieve based on user login status
    $project_count = $is_logged_in ? 6 : 3;

    // Set the project type
    $project_type = 'architecture';

    // Query arguments for fetching projects
    $args = array(
        'post_type'      => 'projects',
        'posts_per_page' => $project_count,
        'tax_query'      => array(
            array(
                'taxonomy' => 'project_type',
                'field'    => 'slug',
                'terms'    => $project_type,
            ),
        ),
    );

    // Fetch the projects
    $projects_query = new WP_Query( $args );

    // Prepare the JSON response
    $response = array(
        'success' => true,
        'data'    => array(),
    );

    // Process the queried projects
    if ( $projects_query->have_posts() ) {
        while ( $projects_query->have_posts() ) {
            $projects_query->the_post();
            $project_id = get_the_ID();
            $project_title = get_the_title();
            $project_link = get_permalink();

            $project_data = array(
                'id'    => $project_id,
                'title' => $project_title,
                'link'  => $project_link,
            );

            // Append project data to the response
            $response['data'][] = $project_data;
        }
    }

    // Reset the post data
    wp_reset_postdata();

    // Send the JSON response
    wp_send_json( $response );
}


add_action('wp_head', 'ajax_script');
function ajax_script(){
	?>
	<script>
		var ajax_object = {
			ajax_url: '<?php echo admin_url( 'admin-ajax.php' ); ?>'
		};
		jQuery(document).ready(function($) {
			// AJAX request
			$.ajax({
				url: ajax_object.ajax_url,
				type: 'POST',
				data: {
					action: 'fetch_projects', // Replace with your own AJAX action
				},
				success: function(response) {
					console.log(response);
				},
				error: function(xhr, textStatus, errorThrown) {
					console.log('AJAX request failed: ' + errorThrown);
				}
			});
		});
	</script>
	<?php
}



/**
 *  Use the WordPress HTTP API to create a function called hs_give_me_coffee() that will return a direct link to a cup of coffee. for us using the Random Coffee API [JSON].
 */ 



function hs_give_me_coffee() {
    // Make a request to the Random Coffee API
    $response = wp_remote_get('Endpoint where you will hit and get the data in json');

    // Check if the request was successful
    if (is_array($response) && !is_wp_error($response)) {
        // Get the response body
        $body = wp_remote_retrieve_body($response);

        // Decode the JSON response
        $data = json_decode($body);

        // Check if the JSON decoding was successful
        if ($data) {
            // Get the direct link to the coffee
            $link = $data->link;

            // Return the coffee link
            return $link;
        }
    }

    // Return null if there was an error or the response was invalid
    return null;
}

//You can then call the hs_give_me_coffee() function wherever you want to display the link to the coffee. For example:

// $coffeeLink = hs_give_me_coffee();
// if ($coffeeLink) {
//     echo '<a href="' . esc_url($coffeeLink) . '">Get a Cup of Coffee</a>';
// } else {
//     echo 'Sorry, could not fetch the coffee link.';
// }





/**
 * Template Name: Kanye Quotes Page
 */

$page = get_page_by_title('Kanye Quotes');


if (!$page) {
// Create a new page
$new_page = array(
    'post_title'    => 'Kanye Quotes', // Set the title of the page
    'post_status'   => 'publish', // Set the status to publish
    'post_type'     => 'page', // Set the post type to page
);

// Insert the new page into the database
$new_page_id = wp_insert_post($new_page);
}

