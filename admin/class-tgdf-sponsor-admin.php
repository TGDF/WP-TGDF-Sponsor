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
        register_post_type( 'sponsor',
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
     * Add meta boxes
     *
     * @since 1.0.0
     */
    public function add_link_meta_boxes() {
        add_meta_box(
            'sponsor-link',
            esc_html__( 'Link', TGDF_Sponsor_I18n::textdomain() ),
            array( $this, 'link_meta_box' ),
            'sponsor',
            'normal',         // Context
            'default'         // Priority
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

    /**
     * Link meta box callback
     *
     * @since 1.0.0
     */
    public function link_meta_box( $object, $box ) {
?>
    <?php wp_nonce_field( basename( __FILE__ ), 'sponsor_link_nonce' ); ?>

    <p>
      <label for="sponsor-link"><?php _e( "The sponsor website link", TGDF_Sponsor_I18n::textdomain() ); ?></label>
      <br />
      <input class="widefat" type="text" name="sponsor-link" id="sponsor-link" value="<?php echo esc_attr( get_post_meta( $object->ID, 'sponsor-link', true ) ); ?>" size="30" />
    </p>
<?php
    }

    /**
     * Save post meta box
     *
     * @since 1.0.0
     */
    public function save_link_meta( $post_id, $post ) {
        if ( !isset( $_POST['sponsor_link_nonce'] ) || !wp_verify_nonce( $_POST['sponsor_link_nonce'], basename( __FILE__ ) ) ) {
            return $post_id;
        }

        $post_type = get_post_type_object( $post->post_type );

        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
            return $post_id;
        }

        $new_meta_value = ( isset( $_POST['sponsor-link'] ) ? sanitize_text_field( $_POST['sponsor-link'] ) : '' );

        $meta_key = 'sponsor-link';

        $meta_value = get_post_meta( $post_id, $meta_key, true );

        if ( $new_meta_value && '' == $meta_value ) {
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );
        } elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
            update_post_meta( $post_id, $meta_key, $new_meta_value );
        } elseif ( '' == $new_meta_value && $meta_value ) {
            delete_post_meta( $post_id, $meta_key, $meta_value );
        }
    }
}
