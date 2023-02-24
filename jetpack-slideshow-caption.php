<?php
/*
Plugin Name: Slideshow Captions for Jetpack
Plugin URI: https://michaelbox.net
Description: Modifies Jetpack's default slideshow caption feature.
Author: Michael Beckwith
Version: 1.0.3
Author URI: https://michaelbox.net
License: GPLv2
*/

add_action( 'wp_footer', 'wds_replace_jetpack_scripts', 5 );
/**
 * Hijacks Jetpack's enqueueing of it's slideshow JS/CSS and replaces with our own modified versions.
 */
function wds_replace_jetpack_scripts() {

	// Is the 'jetpack-slideshow' script enqueued?
	if ( wp_script_is( 'jetpack-slideshow' ) ) {

		// Remove Jetpack's JS & CSS.
		wp_deregister_script( 'jetpack-slideshow' );
		wp_deregister_style( 'jetpack-slideshow' );

		// & instead enqueue our own modified versions.
		wp_enqueue_script( 'jetpack-slideshow', plugins_url( 'jetpack-slideshow.js', __FILE__ ), array( 'jquery-cycle' ), '1.0', true );
		wp_enqueue_style( 'jetpack-slideshow', plugins_url( 'jetpack-slideshow.css', __FILE__ ), null, '1.0' );

		// Script needs to be re-localized.
		wp_localize_script( 'jetpack-slideshow', 'jetpackSlideshowSettings', apply_filters( 'jetpack_js_slideshow_settings', array(
			'spinner' => plugins_url( 'img/slideshow-loader.gif', __FILE__ ),
		) ) );

	}

}
