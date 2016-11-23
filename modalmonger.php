<?php
/*
Plugin Name: Modal Monger
Plugin URI:  https://github.com/andrewklimek/modalmonger/
Description: a very light modal shortcode that isn't that ugly
Version:     1.3.0
Author:      Andrew J Klimek
Author URI:  https://readycat.net
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Modal Monger is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Modal Monger is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Modal Monger. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


// TODO sanitize label attribute

add_action( 'wp_enqueue_scripts', function() {
	$suffix = SCRIPT_DEBUG ? '' : '.min';
	wp_register_style( 'modalmonger', plugin_dir_url( __FILE__ ) . 'modalmonger' . $suffix . '.css', array(), null, 'screen' );
	wp_register_script( 'modalmonger', plugin_dir_url( __FILE__ ) . 'modalmonger' . $suffix . '.js', array(), null, true );
	
	//localize data for script
	$prefix = esc_attr( apply_filters( 'modalmonger_trigger_selectors', '#mm-' ) );
	$selector = $prefix ? ', a[href*="'. $prefix .'"]' : '';
	wp_localize_script( 'modalmonger', 'urlTrigger', array( 'prefix' => $prefix, 'selector' => $selector ) );
});



function modalmonger_shortcode( $atts, $content = '' ) {
	
	if ( ! $content && empty($atts['login'] ) ) return '<code>Please add a closing [/modalmonger] shortcode at the end of the modal content</code>';
	
	// Load previously registered scripts only if shortcode is used.
	wp_enqueue_style( 'modalmonger' );
	wp_enqueue_script( 'modalmonger' );

	$atts = shortcode_atts( array(
		'id' => 0,
		'label' => null,
		'href' => 0,
		'class' => 0,
		'suffix' => mt_rand(),
		'width' => 0,
		'height' => 0,
		'login' => null,
		'link' => 1,
	), $atts, 'modalmonger' );
	
	// Cleaning up, using empty(), and re-stating defaults since they can filter with 'shortcode_atts_modalmonger'
	
	$id = empty( $atts['id'] ) ? '' : " id='". sanitize_html_class( $atts['id'] ) ."'";
	$label = ! isset( $atts['label'] ) ? 'Click Me' : $atts['label'];// !isset because they can set label='' for no label.
	$href = empty( $atts['href'] ) ? '' : esc_url( $atts['href'] );
	$class = empty( $atts['class'] ) ? '' : " class='". sanitize_html_class( $atts['class'] ) ."'";
	$suffix = empty( $atts['suffix'] ) ? mt_rand() : preg_replace( '/[^-\w]/', '', $atts['suffix'] );
	$width = empty( $atts['width'] ) ? '' : "width: {$atts['width']};";
	$height = empty( $atts['height'] ) ? '' : "height: {$atts['height']};";
	$style = ! ( $width || $height ) ? '' : " style='{$width}{$height}'";
	
	$link = ! $atts['link'] ? '' : "<a{$id} href='{$href}'{$class} data-modalmonger-trigger={$suffix}>{$label}</a>";
	
	$content = !empty($atts['login'] ) ? wp_login_form( array('echo' => false ) ) : do_shortcode( $content );
	
	$content = "{$link}
		<div id='modalmonger-{$suffix}' class='modalmonger' style='display:none;'>
			<div class='modalmonger-content'{$style}>
				<a class='modalmonger-close' href='/' data-modalmonger='{$suffix}'>
				<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path d='M13.4 12l9.3-9.3c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0L12 10.6 2.7 1.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4l9.3 9.3-9.3 9.3c-.4.4-.4 1 0 1.4.4.4 1 .4 1.4 0l9.3-9.3 9.3 9.3c.4.4 1 .4 1.4 0 .4-.4.4-1 0-1.4L13.4 12z'/></svg>
				</a>
				{$content}
			</div>
		</div>
		";
	return $content;
}
add_shortcode( 'modalmonger', 'modalmonger_shortcode' );



// add login shortcode
// add_shortcode( 'show_login_modal', function($a, $c = ''){ return (is_user_logged_in()) ? $c: '<style>#modalmonger-login{display:block}</style>'; });

