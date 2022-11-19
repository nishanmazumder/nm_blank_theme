<?php

/**
 *  Template Hook
 *
 * @package NM_THEME
 *
 */


// Site Logo - From Customizer
add_action('nm_logo', 'nm_get_logo');

function nm_get_logo()
{
    if (function_exists('the_custom_logo')) {
        $nm_usc_logo_id = get_theme_mod('custom_logo');
        $nm_usc_logo = wp_get_attachment_image_src($nm_usc_logo_id, 'full');

        if (has_custom_logo()) {
            echo '<a href="' . home_url() . '"><img class="" style="width: 100px" src="' . esc_url($nm_usc_logo[0]) . '" alt="' . get_bloginfo('name') . '"></a>';
        } else {
            echo '<h1>' . get_bloginfo('name') . '</h1>';
        }
    }
}

// Hook - Main Menu
add_action('nm_menu', 'nm_get_menu');

function nm_get_menu()
{

    $menu = NM_THEME\Classes\Menus::get_instance();
    $menu_id = $menu->get_menu_id('nm-theme-main-menu');
    $menu_items = wp_get_nav_menu_items($menu_id);

    if (!empty($menu_items) && is_array($menu_items)) { ?>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <?php
            foreach ($menu_items as $menu_item) {
                if (!$menu_item->menu_item_parent) {

                    $child_menu_items = $menu->get_child_menu_items($menu_item->ID, $menu_items);
                    $has_child = !empty($child_menu_items) && is_array($child_menu_items);

                    if (!$has_child) { ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?php echo esc_url($menu_item->url) ?>"><?php echo esc_html($menu_item->title); ?></a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo esc_html($menu_item->title); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($child_menu_items as $menu_item) { ?>
                                    <a class="nav-link active" aria-current="page" href="<?php echo esc_url($menu_item->url) ?>"><?php echo esc_html($menu_item->title); ?></a>
                                <?php } ?>
                            </ul>
                        </li>

                    <?php }

                    ?>

            <?php  }
            } ?>
        </ul>
<?php
    }
}

// Get Page title

add_action('nm_page_title', 'nm_get_page_title');

function nm_get_page_title()
{
    $page_title_show = get_post_meta(get_the_ID(), '_hide_page_meta_key');

    if (is_array($page_title_show) && in_array('yes', $page_title_show)) {
        echo esc_html(wp_title(''));
    }
}
