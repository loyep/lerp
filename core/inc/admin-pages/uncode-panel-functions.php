<?php
/**
 * Functions for the Uncode panel menu.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get panel menu pages.
 *
 * @return array
 */
function uncode_get_admin_panel_menu_pages() {
	$pages = array(
		'welcome' => array(
			'title'       => esc_html__( '欢迎', 'uncode' ),
			'page_title'  => esc_html__( '欢迎使用Lerp', 'uncode' ),
			'description' => sprintf( esc_html__( "%s is installed! Please register your purchase, make sure that you've fulfilled all of the requirements below, and look for a green success message.", "uncode" ), UNCODE_NAME ),
			'url'         => admin_url( 'admin.php?page=uncode-system-status' )
		),
		'plugins' => array(
			'title'       => esc_html__( '插件', 'uncode' ),
			'page_title'  => esc_html__( '插件', 'uncode' ),
			'description' => esc_html__( 'Uncode Core and Uncode Visual Composer (WPBakery Page Builder) are the only required plugins. Any other plugins are optional.', 'uncode' ),
			'url'         => admin_url( 'admin.php?page=uncode-plugins' )
		),
		'fonts' => array(
			'title'       => esc_html__( '字体库', 'uncode' ),
			'page_title'  => esc_html__( '字体库', 'uncode' ),
			'description' => esc_html__( '从最流行的字体库导入字体并创建字体堆栈。', 'uncode' ),
			'url'         => admin_url( 'admin.php?page=uncode-font-stacks' )
		),
		'utils' => array(
			'title'       => esc_html__( '设置工具', 'uncode' ),
			'page_title'  => esc_html__( '设置工具', 'uncode' ),
			'description' => esc_html__( 'Find useful tools to save as manual backup or to export/import your Theme Options.', 'uncode' ),
			'url'         => admin_url( 'admin.php?page=uncode-settings' )
		),
	);

	if ( ot_get_option('_uncode_admin_help') !== 'off' ) {
		$pages['support'] = array(
			'title'       => esc_html__( '支持', 'uncode' ),
			'page_title'  => esc_html__( '支持', 'uncode' ),
			'description' => esc_html__( '帮助您了解如何使用Lerp主题', 'uncode' ),
			'url'         => admin_url( 'admin.php?page=uncode-support' )
		);
	}

	return apply_filters( 'uncode_get_admin_panel_menu_pages', $pages );
}

/**
 * Output uncode admin pages title.
 *
 * @return string
 */
function uncode_admin_panel_page_title( $page_id, $data = false ) {
	$pages = uncode_get_admin_panel_menu_pages();

	ob_start();
	?>

	<h2></h2><!-- empty h2 for admin notices -->

	<h1><?php echo esc_html( $data ? $data[ 'page_title' ] : $pages[ $page_id ][ 'page_title' ] ); ?></h1>

	<div class="about-text">
		<?php echo esc_html( $data ? $data[ 'description' ] : $pages[ $page_id ][ 'description' ] ); ?>
	</div>

	<?php
	return ob_get_clean();
}

/**
 * Output uncode panel title.
 *
 * @return string
 */
/*function uncode_admin_panel_title() {
	$active_theme  = wp_get_theme();
	$theme_name    = $active_theme->Name;
	$theme_version = $active_theme->Version;

	if ( is_child_theme() ) {
		$parent_theme  = $active_theme->parent();
		$theme_name    = $parent_theme->Name;
		$theme_version = $parent_theme->Version;
	}

	ob_start();
	?>

	<div class="uncode-admin-panel-title">
		<span class="uncode-admin-panel-title__parent-theme"><?php echo $theme_name . ' ' . $theme_version; ?></span>

		<?php if ( is_child_theme() ) :
			$active_theme  = wp_get_theme();
			?>
			<span class="uncode-admin-panel-title__sep"> - </span>
			<span class="uncode-admin-panel-title__child-theme"><?php echo esc_html( $active_theme->Name ); ?></span>
		<?php else : ?>

		<?php endif; ?>
	</div>

	<?php
	return ob_get_clean();
}*/

/**
 * Output uncode panel menu.
 *
 * @param  string $active_tab
 * @return string
 */
function uncode_admin_panel_menu( $active_tab ) {
	$pages = uncode_get_admin_panel_menu_pages();

	ob_start();
	?>

	<div class="uncode-admin-panel-menu">
		<ul class="uncode-admin-panel-menu__list">

			<?php foreach ( $pages as $page_id => $page ) : ?>
				<li class="uncode-admin-panel-menu__item uncode-admin-panel-menu__item--<?php echo esc_attr( $page_id ); ?>">

					<?php if ( $active_tab == $page_id ) : ?>

						<span class="uncode-admin-panel-menu__link uncode-admin-panel-menu__link--<?php echo $page_id; ?> uncode-admin-panel-menu__link--active"><?php echo $page[ 'title' ]; ?></span>
					<?php else : ?>

						<a href="<?php echo esc_url( $page[ 'url' ] ) ?>" class="uncode-admin-panel-menu__link uncode-admin-panel-menu__link--<?php echo $page_id; ?>"><?php echo $page[ 'title' ]; ?></a>
					<?php endif; ?>

				</li>
			<?php endforeach; ?>

		</ul>
	</div>

	<?php
	return ob_get_clean();
}

/**
 * Output markup before TGMPA form.
 * We are using an action to have less changes in the original TGMPA class.
 *
 * This markup replaces the opening <div class="tgmpa wrap"> div
 *
 * @return string
 */
function uncode_open_tgmpa_form() {
	ob_start();
	?>
	<div class="tgmpa wrap uncode-wrap">
		<?php echo uncode_admin_panel_page_title( 'plugins' ); ?>

		<div class="uncode-admin-panel">
			<?php //echo uncode_admin_panel_title(); ?>
			<?php echo uncode_admin_panel_menu( 'plugins' ); ?>

			<div class="uncode-admin-panel__content">
				<h2 class="uncode-admin-panel__heading"><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php
	echo ob_get_clean();
}
add_action( 'uncode_before_tgmpa_form', 'uncode_open_tgmpa_form' );

/**
 * Output markup after TGMPA form.
 * We are using an action to have less changes in the original TGMPA class.
 *
 * This markup replaces the closing <div class="tgmpa wrap"> div
 *
 * @return string
 */
function uncode_close_tgmpa_form() {
	ob_start();
	?>
			</div><!-- .uncode-admin-panel__content -->
		</div><!-- .uncode-admin-panel -->
	</div><!-- .uncode-wrap -->

	<?php
	echo ob_get_clean();
}
add_action( 'uncode_after_tgmpa_form', 'uncode_close_tgmpa_form' );
