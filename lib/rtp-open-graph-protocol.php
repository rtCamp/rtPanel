<?php
/**
 * rtPanel support for Facebook Open Graph Protocol
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

/**
 * Facebook Open Graph Protocol
 *
 * @since rtPanel 2.0
 */
class rtp_ogp {
    
    var $data;

    /**
     * Constructor
     *
     * @return void
     *
     * @since rtPanel 2.0
     **/
    function rtp_ogp() {
        add_action( 'wp_head', array( $this, 'rtp_ogp_add_head' ) );
    }

    /**
     * Outputs Open Graph meta tags
     *
     * @since rtPanel 2.0
     **/
    function rtp_ogp_add_head() {
        $this->data = $this->rtp_ogp_set_data();
        echo $this->rtp_ogp_get_headers( $this->data );
    }

    /**
     * Sets Open Graph meta tags
     *
     * @return array
     *
     * @since rtPanel 2.0
     **/
    function rtp_ogp_set_data() {
        global $post, $rtp_general;
        $data = array();
        
        if ( !empty( $rtp_general['fb_app_id'] ) )
            $data['fb:app_id'] = $rtp_general['fb_app_id'];

        if ( !empty( $rtp_general['fb_admins'] ) )
            $data['fb:admins'] = $rtp_general['fb_admins'];

        $data['og:site_name'] = get_bloginfo('name');

        if ( is_singular () && !is_front_page() ) {
            $append = '';
            $post_content = ( isset( $post->post_excerpt ) && trim( $post->post_excerpt ) ) ? $post->post_excerpt : $post->post_content;
            if( strlen( wp_html_excerpt( $post_content, 130 ) ) >= 130 )
                $append = '...';
            
            $data['og:title'] = esc_attr( $post->post_title );
            $data['og:type'] = 'article';
            $data['og:image'] = $this->rtp_ogp_image_url();
            $data['og:url'] = get_permalink();
            $data['og:description'] = esc_attr( wp_html_excerpt( $post_content, 130 ).$append );
        } else {
            $data['og:title'] = get_bloginfo('name');
            $data['og:type'] = 'website';
            $data['og:image'] = $this->rtp_ogp_image_url();
            $data['og:url'] = home_url( $_SERVER['REQUEST_URI'] );
            $data['og:description'] = get_bloginfo('description');
        }
        return $data;
    }

    /**
     * Returns Formatted Open Graph meta tags
     *
     * @return array
     *
     * @since rtPanel 2.0
     **/
    function rtp_ogp_get_headers($data) {
        if ( !count( $data ) ) {
            return;
        }
        $out = array();
        $out[] = "\n<!-- BEGIN: Open Graph Protocol : http://opengraphprotocol.org/ for more info -->";
        foreach ($data as $property => $content) {
            if ($content != '') {
                $out[] = "<meta property=\"{$property}\" content=\"" . apply_filters( 'rtp_ogp_content_' . $property, $content ) . "\" />";
            } else {
                $out[] = "<!--{$property} value was blank-->";
            }
        }
        $out[] = "<!-- End: Open Graph Protocol -->\n";
        return implode("\n", $out);
    }

    /**
     * Returns Open Graph image meta tag value
     *
     * @return string
     *
     * @since rtPanel 2.0
     **/
    function rtp_ogp_image_url() {
        global $post, $rtp_general;
        $image = '';
        if ( is_singular() && !is_front_page() ) {
            if (has_post_thumbnail($post->ID)) {
                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' );
                if ( !empty ( $thumbnail ) ) {
                    $image = $thumbnail[0];
                }
            } else {                
                $image = apply_filters( 'rtp_default_ogp_image_path', '' );                
                if(empty($image)){
                    $image = $rtp_general['logo_upload'];
                }
            }
        } else {
            $image = $rtp_general['logo_upload'];
        }        
        return $image;
    }
}

global $rtp_general;
if( !empty( $rtp_general['fb_app_id'] ) || !empty( $rtp_general['fb_admins'] ) ) {
// Facebook Open Graph Protocol
    $rtp_ogp = new rtp_ogp();
}
?>