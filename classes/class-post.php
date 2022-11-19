<?php

/**
 *
 * Post Type
 *
 * @package NM_THEME
 *
 */

namespace NM_THEME\Classes;

use NM_THEME\Traits\Singleton;

class Post_Type
{

    use Singleton;

    protected function __construct()
    {
        $this->setup_hooks();
    }

    public function setup_hooks()
    {
        add_action('init', [$this, 'protestimonial_init']);
        //add_action('init', [$this, 'disable_post_type_features']);
        add_filter('post_updated_messages', [$this, 'protestimonial_updated_messages']);
        add_filter('bulk_post_updated_messages', [$this, 'protestimonial_bulk_updated_messages'], 10, 2);
    }

    /**
     * Registers the `protestimonial` post type.
     */
    public function protestimonial_init()
    {
        register_post_type(
            'protestimonial',
            [
                'labels'                => [
                    'name'                  => __('Pro Testimonials', 'protestimonial'),
                    'singular_name'         => __('Pro Testimonial', 'protestimonial'),
                    'all_items'             => __('All Testimonials', 'protestimonial'),
                    'archives'              => __('Testimonial Archives', 'protestimonial'),
                    'attributes'            => __('Testimonial Attributes', 'protestimonial'),
                    'insert_into_item'      => __('Insert into Testimonial', 'protestimonial'),
                    'uploaded_to_this_item' => __('Uploaded to this Testimonial', 'protestimonial'),
                    'featured_image'        => _x('Featured Image', 'protestimonial', 'protestimonial'),
                    'set_featured_image'    => _x('Set featured image', 'protestimonial', 'protestimonial'),
                    'remove_featured_image' => _x('Remove featured image', 'protestimonial', 'protestimonial'),
                    'use_featured_image'    => _x('Use as featured image', 'protestimonial', 'protestimonial'),
                    'filter_items_list'     => __('Filter Testimonials list', 'protestimonial'),
                    'items_list_navigation' => __('Testimonials list navigation', 'protestimonial'),
                    'items_list'            => __('Testimonials list', 'protestimonial'),
                    'new_item'              => __('New Testimonial', 'protestimonial'),
                    'add_new'               => __('Add New', 'protestimonial'),
                    'add_new_item'          => __('Add New Testimonial', 'protestimonial'),
                    'edit_item'             => __('Edit Testimonial', 'protestimonial'),
                    'view_item'             => __('View Testimonial', 'protestimonial'),
                    'view_items'            => __('View Testimonials', 'protestimonial'),
                    'search_items'          => __('Search Testimonials', 'protestimonial'),
                    'not_found'             => __('No Testimonials found', 'protestimonial'),
                    'not_found_in_trash'    => __('No Testimonials found in trash', 'protestimonial'),
                    'parent_item_colon'     => __('Parent Testimonial:', 'protestimonial'),
                    'menu_name'             => __('Testimonials', 'protestimonial'),
                ],
                'public'                => true,
                'hierarchical'          => false,
                'show_ui'               => true,
                'show_in_nav_menus'     => true,
                'supports'              => ['thumbnail', 'editor', 'title'],
                'has_archive'           => true,
                'rewrite'               => true,
                'query_var'             => true,
                'menu_position'         => null,
                'menu_icon'             => 'dashicons-format-status',
                'show_in_rest'          => true,
                'rest_base'             => 'protestimonial',
                'rest_controller_class' => 'WP_REST_Posts_Controller',
            ]
        );
    }

    /**
     * Remove editor from post type
     */
    public function disable_post_type_features()
    {
        remove_post_type_support('protestimonial', 'editor');
    }


    /**
     * Sets the post updated messages for the `protestimonial` post type.
     *
     * @param  array $messages Post updated messages.
     * @return array Messages for the `protestimonial` post type.
     */
    public function protestimonial_updated_messages($messages)
    {
        global $post;

        $permalink = get_permalink($post);

        $messages['protestimonial'] = [
            0  => '', // Unused. Messages start at index 1.
            /* translators: %s: post permalink */
            1  => sprintf(__('Testimonial updated. <a target="_blank" href="%s">View Testimonial</a>', 'protestimonial'), esc_url($permalink)),
            2  => __('Custom field updated.', 'protestimonial'),
            3  => __('Custom field deleted.', 'protestimonial'),
            4  => __('Testimonial updated.', 'protestimonial'),
            /* translators: %s: date and time of the revision */
            5  => isset($_GET['revision']) ? sprintf(__('Testimonial restored to revision from %s', 'protestimonial'), wp_post_revision_title((int) $_GET['revision'], false)) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            /* translators: %s: post permalink */
            6  => sprintf(__('Testimonial published. <a href="%s">View Testimonial</a>', 'protestimonial'), esc_url($permalink)),
            7  => __('Testimonial saved.', 'protestimonial'),
            /* translators: %s: post permalink */
            8  => sprintf(__('Testimonial submitted. <a target="_blank" href="%s">Preview Testimonial</a>', 'protestimonial'), esc_url(add_query_arg('preview', 'true', $permalink))),
            /* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
            9  => sprintf(__('Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Testimonial</a>', 'protestimonial'), date_i18n(__('M j, Y @ G:i', 'protestimonial'), strtotime($post->post_date)), esc_url($permalink)),
            /* translators: %s: post permalink */
            10 => sprintf(__('Testimonial draft updated. <a target="_blank" href="%s">Preview Testimonial</a>', 'protestimonial'), esc_url(add_query_arg('preview', 'true', $permalink))),
        ];

        return $messages;
    }

    /**
     * Sets the bulk post updated messages for the `protestimonial` post type.
     *
     * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
     *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
     * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
     * @return array Bulk messages for the `protestimonial` post type.
     */
    public function protestimonial_bulk_updated_messages($bulk_messages, $bulk_counts)
    {
        global $post;

        $bulk_messages['protestimonial'] = [
            /* translators: %s: Number of Testimonials. */
            'updated'   => _n('%s Testimonial updated.', '%s Testimonials updated.', $bulk_counts['updated'], 'protestimonial'),
            'locked'    => (1 === $bulk_counts['locked']) ? __('1 Testimonial not updated, somebody is editing it.', 'protestimonial') :
                /* translators: %s: Number of Testimonials. */
                _n('%s Testimonial not updated, somebody is editing it.', '%s Testimonials not updated, somebody is editing them.', $bulk_counts['locked'], 'protestimonial'),
            /* translators: %s: Number of Testimonials. */
            'deleted'   => _n('%s Testimonial permanently deleted.', '%s Testimonials permanently deleted.', $bulk_counts['deleted'], 'protestimonial'),
            /* translators: %s: Number of Testimonials. */
            'trashed'   => _n('%s Testimonial moved to the Trash.', '%s Testimonials moved to the Trash.', $bulk_counts['trashed'], 'protestimonial'),
            /* translators: %s: Number of Testimonials. */
            'untrashed' => _n('%s Testimonial restored from the Trash.', '%s Testimonials restored from the Trash.', $bulk_counts['untrashed'], 'protestimonial'),
        ];

        return $bulk_messages;
    }

    public function __construnct()
    {
    }
    public function __clone()
    {
    }
}
