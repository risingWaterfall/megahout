<?php
/**
 * @package WordPress
 * @subpackage megahout
 * @since megahout 1.0
 */

	// Options Framework (https://github.com/devinsays/options-framework-plugin)
	if ( !function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/_inc/' );
		require_once dirname( __FILE__ ) . '/_inc/options-framework.php';
	}

	// Theme Setup (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	function megahout_setup() {
		load_theme_textdomain( 'megahout', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'structured-post-formats', array( 'link', 'video' ) );
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'quote', 'status' ) );
		register_nav_menu( 'primary', __( 'Navigation Menu', 'megahout' ) );
		add_theme_support( 'post-thumbnails' );
	}
	add_action( 'after_setup_theme', 'megahout_setup' );

	// Scripts & Styles (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	/**
 	* Enqueue megahout scripts
 	* @return void
 	*/
	// Load jQuery
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"), false);
	   wp_enqueue_script('jquery');
	}

	    
	function megahout_enqueue_scripts() {
	    wp_enqueue_style( 'megahout-styles', get_template_directory_uri() . '/static/css/style.css' ); //our stylesheet
	    wp_enqueue_script( 'jquery' );
	    wp_enqueue_script( 'default-scripts', get_template_directory_uri() . '/static/js/footer.js', array(), '1.0', true );
	    if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	}
	add_action( 'wp_enqueue_scripts', 'megahout_enqueue_scripts' );



	

	// WP Title (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	function megahout_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() )
			return $title;

//		 Add the site name.
		$title .= get_bloginfo( 'name' );

//		 Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

//		 Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'megahout' ), max( $paged, $page ) );
//FIX
//		if (function_exists('is_tag') && is_tag()) {
//		   single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
//		elseif (is_archive()) {
//		   wp_title(''); echo ' Archive - '; }
//		elseif (is_search()) {
//		   echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
//		elseif (!(is_404()) && (is_single()) || (is_page())) {
//		   wp_title(''); echo ' - '; }
//		elseif (is_404()) {
//		   echo 'Not Found - '; }
//		if (is_home()) {
//		   bloginfo('name'); echo ' - '; bloginfo('description'); }
//		else {
//		    bloginfo('name'); }
//		if ($paged>1) {
//		   echo ' - page '. $paged; }

		return $title;
	}
	add_filter( 'wp_title', 'megahout_wp_title', 10, 2 );




	// Custom Menu
	register_nav_menu( 'primary', __( 'Navigation Menu', 'megahout' ) );

	// Widgets
	if ( function_exists('register_sidebar' )) {
		function megahout_widgets_init() {
			register_sidebar( array(
				'name'          => __( 'Sidebar Widgets', 'megahout' ),
				'id'            => 'sidebar-primary',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}
		add_action( 'widgets_init', 'megahout_widgets_init' );
	}

	// Navigation - update coming from twentythirteen
	function post_navigation() {
		echo '<div class="navigation">';
		echo '	<div class="next-posts">'.get_next_posts_link('&laquo; Older Entries').'</div>';
		echo '	<div class="prev-posts">'.get_previous_posts_link('Newer Entries &raquo;').'</div>';
		echo '</div>';
	}

	// Posted On
	function posted_on() {
		printf( __( '<span class="sep">Posted </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a> by <span class="byline author vcard">%5$s</span>', '' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_author() )
		);
	}





/* Uncomment to add custom image sizes

function megahout_add_image_sizes() {
    add_image_size( 'megahout-thumb', 300, 100, true );
    add_image_size( 'megahout-large', 600, 300, true );
}
add_action( 'init', 'megahout_add_image_sizes' );
 


function megahout_show_image_sizes($sizes) {
    $sizes['megahout-thumb'] = __( 'megahout Thumb', 'megahout' );
    $sizes['megahout-large'] = __( 'megahout Large', 'megahout' );
 
    return $sizes;
}
add_filter('image_size_names_choose', 'megahout_show_image_sizes');

*/





/* Uncomment to add minimum image upload sizes

add_filter('wp_handle_upload_prefilter','megahout_handle_upload_prefilter');
//Set the minimum file sizes
$minimumWidth = '640';
$minimumHeight = '480';

function megahout_handle_upload_prefilter($file)
{

    $img=getimagesize($file['tmp_name']);
    $minimum = array('width' => $minimumWidth, 'height' => $minimumHeight);
    $width= $img[0];
    $height =$img[1];

    if ($width < $minimum['width'] )
        return array("error"=>"Image dimensions are too small. Minimum width is {$minimum['width']}px. Uploaded image width is $width px");

    elseif ($height <  $minimum['height'])
        return array("error"=>"Image dimensions are too small. Minimum height is {$minimum['height']}px. Uploaded image height is $height px");
    else
        return $file; 
}
*/
?>