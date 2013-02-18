<?php
/**
 * rtPanel functions and definitions
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

define( 'RTP_VERSION', '3.0' );

/* Define Directory Constants */
define( 'RTP_ADMIN', get_template_directory() . '/admin' );
define( 'RTP_CSS', get_template_directory() . '/css' );
define( 'RTP_JS', get_template_directory() . '/js' );
define( 'RTP_IMG', get_template_directory() . '/img' );

/* Define Directory URL Constants */
define( 'RTP_TEMPLATE_URL', get_template_directory_uri() );
define( 'RTP_CSS_FOLDER_URL', get_template_directory_uri() . '/css' );
define( 'RTP_JS_FOLDER_URL', get_template_directory_uri() . '/js' );
define( 'RTP_IMG_FOLDER_URL', get_template_directory_uri() . '/img' );

$rtp_general = get_option( 'rtp_general' ); // rtPanel General Options
$rtp_post_comments = get_option( 'rtp_post_comments' ); // rtPanel Post & Comments Options
$rtp_version = get_option( 'rtp_version' ); // rtPanel Version

/* Check if default values are present in the database else force defaults - Since rtPanel v2.1 */
$rtp_general['pagination_show'] = isset( $rtp_general['pagination_show'] ) ? $rtp_general['pagination_show'] : 0;
$rtp_post_comments['prev_text'] = isset( $rtp_post_comments['prev_text'] ) ? $rtp_post_comments['prev_text'] : __( '&laquo; Previous', 'rtPanel' );
$rtp_post_comments['next_text'] = isset( $rtp_post_comments['next_text'] ) ? $rtp_post_comments['next_text'] : __( 'Next &raquo;', 'rtPanel' );
$rtp_post_comments['end_size']  = isset( $rtp_post_comments['end_size'] ) ? $rtp_post_comments['end_size'] : 1;
$rtp_post_comments['mid_size']  = isset( $rtp_post_comments['mid_size'] ) ? $rtp_post_comments['mid_size'] : 2;
$rtp_post_comments['attachment_comments']  = isset( $rtp_post_comments['attachment_comments'] ) ? $rtp_post_comments['attachment_comments'] : 0;

/* Includes PHP files located in 'lib' folder */
foreach( glob ( get_template_directory() . "/lib/*.php" ) as $lib_filename ) {
    require_once( $lib_filename );
}

/* Includes rtPanel Theme Options */
require_once( get_template_directory() . "/admin/rtp-theme-options.php" );