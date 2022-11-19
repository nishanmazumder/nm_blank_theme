<?php

/**
 *
 * Theme Enqueue
 *
 * @package NM_THEME
 *
 */

namespace NM_THEME\Classes;

use NM_THEME\Traits\Singleton;

class Assets
{

    use Singleton;

    protected function __construct()
    {
        $this->setup_hooks();
    }

    protected function setup_hooks()
    {
        /***
         * Actions
         ***/
        add_action('wp_enqueue_scripts', [$this, 'register_styles']);
        add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    }

    public function register_styles()
    {
        // Third-party
        wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css');
        wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css');
        // Third-party

        // Must Use
        wp_enqueue_style('main-css', NM_DIR_URI . '/assets/css/style.css', [], filemtime(NM_DIR_PATH . '/assets/css/style.css'), 'all');
        wp_enqueue_style('stylesheet', NM_STYLE_URI, [], filemtime(NM_DIR_PATH . '/style.css'), 'all');
        // Must Use
    }

    public function register_scripts()
    {
        // Third-party
        wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js', array('jquery'));
        // Third-party

        // Must Use
        wp_enqueue_script('main-js', NM_DIR_URI . '/assets/js/main.js', array('jquery'), filemtime(NM_DIR_PATH . '/assets/js/main.js'), true); //footer
        // Must Use
    }
}
