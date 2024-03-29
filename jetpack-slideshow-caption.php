<?php
/*
Plugin Name: Slideshow Captions for Jetpack
Plugin URI: https://michaelbox.net
Description: Modifies Jetpack's default slideshow caption feature.
Author: Michael Beckwith
Version: 1.1.0
Author URI: https://michaelbox.net
License: GPLv2
*/

/**
 * Hijacks Jetpack's enqueueing of it's slideshow JS/CSS and replaces with our own modified versions.
 */
function wds_replace_jetpack_scripts() {

	$version = '1.1.0';

	if ( ! class_exists( 'Jetpack' ) || ! Jetpack::is_module_active( 'shortcodes' ) ) {
		return;
	}

	// Is the 'jetpack-slideshow' script enqueued?
	if ( wp_script_is( 'jetpack-slideshow' ) ) {

		// Remove Jetpack's JS & CSS.
		wp_deregister_script( 'jetpack-slideshow' );
		wp_deregister_style( 'jetpack-slideshow' );

		// & instead enqueue our own modified versions.
		wp_enqueue_script( 'jetpack-slideshow', plugins_url( 'jetpack-slideshow.js', __FILE__ ), [ 'jquery-cycle' ], $version, true );
		wp_enqueue_style( 'jetpack-slideshow', plugins_url( 'jetpack-slideshow.css', __FILE__ ), null, $version );

		// Script needs to be re-localized.
		wp_localize_script(
			'jetpack-slideshow',
			'jetpackSlideshowSettings',
			apply_filters(
				'jetpack_js_slideshow_settings',
				[
					'spinner'    => plugins_url( 'img/slideshow-loader.gif', __FILE__ ),
					'speed'      => '4000',
					'label_prev' => __( 'Previous Slide', 'jetpack-slideshow-caption' ),
					'label_stop' => __( 'Pause Slideshow', 'jetpack-slideshow-caption' ),
					'label_next' => __( 'Next Slide', 'jetpack-slideshow-caption' ),
				]
			)
		);
	}
}
add_action( 'wp_footer', 'wds_replace_jetpack_scripts', 5 );
