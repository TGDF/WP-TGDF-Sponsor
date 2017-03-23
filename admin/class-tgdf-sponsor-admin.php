<?php

/**
 * Class TGDF_Sponsor_Admin
 * @author Aotokitsuruya
 */
class TGDF_Sponsor_Admin
{
    /**
     * Define Sponsor's PostType
     *
     * @since 1.0.0
     */
    public function create_post_type() {
        register_post_type( 'tgdf_sponsor',
            array(
                'labels' => array(
                    'name' => __( 'Sponsors', TGDF_Sponsor_I18n::textdomain() ),
                    'singular_name' => __( 'Sponsor', TGDF_Sponsor_I18n::textdomain() )
                ),
                'public' => true,
                'exclude_from_search' => true,
                'menu_position' => 20,
                'supports' => array(
                    'title', 'thumbnail', 'excerpt'
                ),
                'has_archive' => true,
                'rewrite' => array('slug' => 'sponsors'),
                'show_in_rest' => true,
                'rest_base' => 'sponsors',
                'rest_controller_class' => 'TGDF_Sponsor_REST_Controller',
            )
        );
    }

    /**
     * Add image size for logo display
     *
     * @since 1.0.0
     */
    public function add_image_size() {
        add_theme_support( 'post-thumbnails' );

        add_image_size( 'sponsor-logo', 600, 400, true );
        add_image_size( 'sponsor-logo-small', 300, 200, true );
    }

    /**
     * Add image size name
     *
     * @since 1.0.0
     */
    public function register_image_size_names( $sizes ) {
        return array_merge( $sizes, array(
            'sponsor-logo' => __( 'Logo', TGDF_Sponsor_I18n::textdomain() ),
            'sponsor-logo-small' => __( 'Samll Logo', TGDF_Sponsor_I18n::textdomain() ),
        ) );
    }

}
