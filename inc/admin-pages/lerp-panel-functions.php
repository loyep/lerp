<?php
/**
 * Functions for the Lerp panel menu.
 */

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly

/**
 * Get panel menu pages.
 *
 * @return array
 */
function lerp_get_admin_panel_menu_pages()
{
    $pages = array(
        'welcome' => array(
            'title' => esc_html__('Welcome', 'lerp'),
            'page_title' => esc_html__('Welcome to Lerp', 'lerp'),
            'description' => sprintf(esc_html__("%s is installed! Please register your purchase, make sure that you've fulfilled all of the requirements below, and look for a green success message.",
                "lerp"),
                LERP_NAME),
            'url' => admin_url('admin.php?page=lerp-system-status')
        ),
//        'plugins' => array(
//            'title' => esc_html__('Plugins', 'lerp'),
//            'page_title' => esc_html__('Plugins', 'lerp'),
//            'description' => esc_html__('Lerp Core and Lerp Visual Composer (WPBakery Page Builder) are the only required plugins. Any other plugins are optional.',
//                'lerp'),
//            'url' => admin_url('admin.php?page=lerp-plugins')
//        ),
//        'import' => array(
//            'title' => esc_html__('Import Demo', 'lerp'),
//            'page_title' => esc_html__('Import Demo', 'lerp'),
//            'description' => esc_html__('Here you can import demo layouts. This is the easiest way to start building your site. Before you install any demos, please read through the following information.',
//                'lerp'),
//            'url' => admin_url('admin.php?page=lerp-import-demo')
//        ),
//        'fonts' => array(
//            'title' => esc_html__('Font Stacks', 'lerp'),
//            'page_title' => esc_html__('Font Stacks', 'lerp'),
//            'description' => esc_html__('Import fonts from the most popular fonts libraries and create your Font Stacks.',
//                'lerp'),
//            'url' => admin_url('admin.php?page=lerp-font-stacks')
//        ),
//        'utils' => array(
//            'title' => esc_html__('Options Utils', 'lerp'),
//            'page_title' => esc_html__('Options Utils', 'lerp'),
//            'description' => esc_html__('Find useful tools to save as manual backup or to export/import your Theme Options.',
//                'lerp'),
//            'url' => admin_url('admin.php?page=lerp-settings')
//        ),
    );

    if ( ot_get_option('_lerp_admin_help') !== 'off' ) {
        $pages['support'] = array(
            'title' => esc_html__('Support', 'lerp'),
            'page_title' => esc_html__('Support', 'lerp'),
            'description' => esc_html__('Our online documentation is an incredible resource for learning how to use Lerp. We also offer private support throughout our Help Center.',
                'lerp'),
            'url' => admin_url('admin.php?page=lerp-support')
        );
    }

    return apply_filters('lerp_get_admin_panel_menu_pages', $pages);
}

/**
 * Output lerp admin pages title.
 *
 * @return string
 */
function lerp_admin_panel_page_title($page_id, $data = false)
{
    $pages = lerp_get_admin_panel_menu_pages();

    ob_start();
    ?>

    <h2></h2><!-- empty h2 for admin notices -->

    <h1><?php echo esc_html($data ? $data['page_title'] : $pages[$page_id]['page_title']); ?></h1>

    <div class="about-text">
        <?php echo esc_html($data ? $data['description'] : $pages[$page_id]['description']); ?>
    </div>

    <?php
    return ob_get_clean();
}

/**
 * Output lerp panel menu.
 *
 * @param  string $active_tab
 * @return string
 */
function lerp_admin_panel_menu($active_tab)
{
    $pages = lerp_get_admin_panel_menu_pages();

    ob_start();
    ?>

    <div class="lerp-admin-panel-menu">
        <ul class="lerp-admin-panel-menu__list">

            <?php foreach ( $pages as $page_id => $page ) : ?>
                <li class="lerp-admin-panel-menu__item lerp-admin-panel-menu__item--<?php echo esc_attr($page_id); ?>">

                    <?php if ( $active_tab == $page_id ) : ?>

                        <span class="lerp-admin-panel-menu__link lerp-admin-panel-menu__link--<?php echo $page_id; ?> lerp-admin-panel-menu__link--active"><?php echo $page['title']; ?></span>
                    <?php else : ?>

                        <a href="<?php echo esc_url($page['url']) ?>"
                           class="lerp-admin-panel-menu__link lerp-admin-panel-menu__link--<?php echo $page_id; ?>"><?php echo $page['title']; ?></a>
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
function lerp_open_tgmpa_form()
{
    ob_start();
    ?>
    <div class="tgmpa wrap lerp-wrap">
    <?php echo lerp_admin_panel_page_title('plugins'); ?>

    <div class="lerp-admin-panel">
    <?php //echo lerp_admin_panel_title();
    ?>
    <?php echo lerp_admin_panel_menu('plugins'); ?>

    <div class="lerp-admin-panel__content">
    <h2 class="lerp-admin-panel__heading"><?php echo esc_html(get_admin_page_title()); ?></h2>

    <?php
    echo ob_get_clean();
}

add_action('lerp_before_tgmpa_form', 'lerp_open_tgmpa_form');

/**
 * Output markup after TGMPA form.
 * We are using an action to have less changes in the original TGMPA class.
 *
 * This markup replaces the closing <div class="tgmpa wrap"> div
 *
 * @return string
 */
function lerp_close_tgmpa_form()
{
    ob_start();
    ?>
    </div><!-- .lerp-admin-panel__content -->
    </div><!-- .lerp-admin-panel -->
    </div><!-- .lerp-wrap -->

    <?php
    echo ob_get_clean();
}

add_action('lerp_after_tgmpa_form', 'lerp_close_tgmpa_form');