<?php

/**
 * Class TGDF_Sponsor_REST_Controller
 * @author Aotokitsuruya
 */
class TGDF_Sponsor_REST_Controller extends WP_REST_Posts_Controller
{
    /**
     * Prepares a single post output for response.
     *
     * @since 4.7.0
     * @access public
     *
     * @param WP_Post         $post    Post object.
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response Response object.
     */
    public function prepare_item_for_response( $post, $request ) {
        $GLOBALS['post'] = $post;

        setup_postdata( $post );

        $schema = $this->get_item_schema();

        // Base fields for every post.
        $data = array();

        if ( ! empty( $schema['properties']['id'] ) ) {
            $data['id'] = $post->ID;
        }

        if ( ! empty( $schema['properties']['slug'] ) ) {
            $data['slug'] = $post->post_name;
        }

        if ( ! empty( $schema['properties']['status'] ) ) {
            $data['status'] = $post->post_status;
        }

        if ( ! empty( $schema['properties']['link'] ) ) {
            $data['link'] = get_post_meta( $post->ID, 'sponsor-link', true );
        }

        if ( ! empty( $schema['properties']['title'] ) ) {
            add_filter( 'protected_title_format', array( $this, 'protected_title_format' ) );

            $data['title'] = array(
                'raw'      => $post->post_title,
                'rendered' => get_the_title( $post->ID ),
            );

            remove_filter( 'protected_title_format', array( $this, 'protected_title_format' ) );
        }

        if ( ! empty( $schema['properties']['excerpt'] ) ) {
            /** This filter is documented in wp-includes/post-template.php */
            $excerpt = apply_filters( 'the_excerpt', apply_filters( 'get_the_excerpt', $post->post_excerpt, $post ) );
            $data['excerpt'] = array(
                'raw'       => sanitize_text_field($post->post_excerpt),
                'protected' => (bool) $post->post_password,
            );
        }

        if ( ! empty( $schema['properties']['featured_media'] ) ) {
            $data['featured_media'] = (int) get_post_thumbnail_id( $post->ID );
        }

        if ( ! empty( $schema['properties']['logo'] ) ) {
            $data['logo'] = array(
                'normal' => get_the_post_thumbnail_url( $post->ID, 'sponsor-logo' ),
                'small' => get_the_post_thumbnail_url( $post->ID, 'sponsor-logo-small' ),
            );
        }

        $context = ! empty( $request['context'] ) ? $request['context'] : 'view';
        $data    = $this->add_additional_fields_to_object( $data, $request );
        $data    = $this->filter_response_by_context( $data, $context );

        // Wrap the data in a response object.
        $response = rest_ensure_response( $data );

        return apply_filters( "rest_prepare_{$this->post_type}", $response, $post, $request );
    }

    /**
     * Add Sponsor add field
     *
     * @since 1.0.0
     */
    public function add_additional_fields_schema( $schema ) {
        $schema['properties']['logo'] = array(
            'description' => __( 'The logo of the the sponsor', TGDF_Sponsor_I18n::textdomain() ),
            'type'        => 'object',
            'context'     => array( 'view' ),
            'readonly'    => true,
            'properties'  => array(
                'raw'      => array(
                    'normal' => __( 'The normal size of logo', TGDF_Sponsor_I18n::textdomain() ),
                    'type'        => 'string',
                    'context'     => array( 'view' ),
                    'readonly'    => true,
                ),
                'small' => array(
                    'description' => __( 'The small size of logo', TGDF_Sponsor_I18n::textdomain() ),
                    'type'        => 'string',
                    'context'     => array( 'view' ),
                    'readonly'    => true,
                ),
            ),
        );

        $schema['properties']['excerpt']['properties']['raw']['context'] = array( 'view', 'edit' );

        return $schema;
    }
}
