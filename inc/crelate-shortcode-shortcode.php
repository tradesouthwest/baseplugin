<?php

function crelate_shortcode_add_shortcode_cb( $atts ) 
{
	$html = '';
    $src = get_option('crelate_shortcode_options')['crelate_shortcode_url'];

	$att = shortcode_atts( array(
		'src'         => $src,
		'width'       => '100%',
		'height'      => '680px',
		'scrolling'   => 'no',
		'class'       => 'iframe-class',
		'frameborder' => '0'
		), 
		$atts 
		);

	$html .= '<div id="crelate-iframe" style="text-align: center; 
			-webkit-overflow-scrolling:touch; overflow: auto;">';
	$html .= '<iframe src="'. $att['src'] .'" 
			class="'. $att['class'] .'" 
			width="'. $att['width'] .'" 
			height="'. $att['height'] .'" 
			scrolling="'. $att['scrolling'] .'" 
			frameborder="'. $att['frameborder'] .'"></iframe>';


	$html .= '</div>';
	

	return $html;
}
add_shortcode( 'crelate_iframe', 'crelate_shortcode_add_shortcode_cb' );


function crelate_shortcode_row_meta_cb( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		$row_meta = array(
			'support' => '<a href="https://codeable.io" target="_blank">' . __( 'Iframe', 'iframe' ) . '</a>'
		);
		$links = array_merge( $links, $row_meta );
	}
	return (array) $links;
}
add_filter( 'plugin_row_meta', 'crelate_shortcode_row_meta_cb', 10, 2 );
