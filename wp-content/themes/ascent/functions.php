<?php
/**
 * ascent functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ascent
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ascent_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on ascent, use a find and replace
	 * to change 'ascent' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('ascent', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'ascent'),
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
			'ascent_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'ascent_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ascent_content_width()
{
	$GLOBALS['content_width'] = apply_filters('ascent_content_width', 640);
}
add_action('after_setup_theme', 'ascent_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ascent_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'ascent'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'ascent'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'ascent_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function ascent_scripts()
{
	wp_enqueue_style('ascent-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('ascent-style', 'rtl', 'replace');

	// css
	wp_enqueue_style('bootstrap-css', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta3/css/bootstrap.min.css');

	wp_enqueue_style('slick_css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css');
	wp_enqueue_style('slick_theme_css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css');
	wp_enqueue_style('fontawesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css');

	// responsive
	wp_enqueue_style('responsive-style', get_template_directory_uri() . '/responsive.css');

	wp_enqueue_script('custom-js', get_template_directory_uri() . '/js/custom.js', array(), '1.0.0', true);
	wp_enqueue_script('custom-js', get_template_directory_uri() . 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js', array(), '1.0.0', true);
	// js
	wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array(), '1.0.0', true);

	wp_enqueue_script('slick_js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '1.0.0', true);

	wp_enqueue_script('ascent-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'ascent_scripts');

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
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_action('wp_head', 'custom_loader_dev1');
function custom_loader_dev1(){
	?>
	<style>
		/* preloader */
		#preloader {
			display: flex;
			align-items: center;
			justify-content: center;
			position: fixed;
			z-index: 20000;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: var(--dark);
			text-align: center;
		}

		.loader {
			position: absolute;
			width: 30%;
			height: 100%;
			left: 50%;
			top: 50%;
			transform: translateX(-50%) translateY(-50%);
		}

		.loader div:nth-child(1),
		.loader div:nth-child(2),
		.loader div:nth-child(3),
		.loader div:nth-child(4),
		.loader div:nth-child(5) {
			position: absolute;
			width: 17px;
			height: 17px;
			background-color: #fff;
			border-radius: 100%;
			transform: translateX(-50%) translateY(-50%);
			top: 50%;
		}

		.loader div:nth-child(1) {
			left: 27%;
			animation: wobble 1s linear 0.2s infinite;
		}

		.loader div:nth-child(2) {
			left: 38%;
			animation: wobble 1s linear 0.4s infinite;
		}

		.loader div:nth-child(3) {
			left: 50%;
			animation: wobble 1s linear 0.6s infinite;
		}

		.loader div:nth-child(4) {
			left: 62%;
			animation: wobble 1s linear 0.8s infinite;
		}

		.loader div:nth-child(5) {
			left: 74%;
			animation: wobble 1s linear 1s infinite;
		}

		@keyframes wobble {

			0%,
			50%,
			75% {
				transform: translateX(-50%) translateY(-50%) scale(1);
			}

			25% {
				transform: translateX(-50%) translateY(-50%) scale(1.4);
			}
		}
	</style>

	<!-- Preloader -->
		<div id="preloader">
			<div class="loader">
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
		<!-- Preloader -->
	<?php
}