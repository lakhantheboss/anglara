<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ascent
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

	
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		

		<header id="masthead" class="site-header">
			<div class="my_head">
				<div class="container" id="header_container">
					<div class="header_row">
						<div class="site-branding">
							<?php
							the_custom_logo();
							if (is_front_page() && is_home()):
								?>
								<?php
							endif;
							$practice_description = get_bloginfo('description', 'display');
							if ($practice_description || is_customize_preview()):
								?>
							<?php endif; ?>
						</div><!-- .site-branding -->

						<nav id="site-navigation" class="main-navigation">
							<button class="menu-toggle d-lg-none d-block" aria-controls="primary-menu"
								aria-expanded="false">
								<div class="humbergur__menu">
									<svg class="ham hamRotate ham7" viewBox="0 0 100 100" width="60"
										onclick="this.classList.toggle('active')">
										<path class="line top"
											d="m 70,33 h -40 c 0,0 -6,1.368796 -6,8.5 0,7.131204 6,8.5013 6,8.5013 l 20,-0.0013">
										</path>
										<path class="line middle" d="m 70,50 h -40"></path>
										<path class="line bottom"
											d="m 69.575405,67.073826 h -40 c -5.592752,0 -6.873604,-9.348582 1.371031,-9.348582 8.244634,0 19.053564,21.797129 19.053564,12.274756 l 0,-40">
										</path>
									</svg>
								</div>
							</button>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id' => 'primary-menu',
								)
							);
							?>
						</nav><!-- #site-navigation -->
					</div>
				</div>
			</div>
		</header><!-- #masthead -->