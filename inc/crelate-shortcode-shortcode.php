<?php

function crelate_shortcode_getOptions($option, $defaults=array())
{
    $options = get_option($option, array());
    if(!isset($options) || !is_array($options) || empty($options))
        return $defaults;
    return array_merge($defaults, $options);
}

function crelate_shortcode_add_shortcode_cb( $atts ) {

    $src = crelate_shortcode_getOptions(('crelate_shortcode_options' )['crelate_shortcode_url']);

	$defaults = array(
		'src' => $src,
		'width' => '100%',
		'height' => '',
		'scrolling' => 'no',
		'class' => 'iframe-class',
		'frameborder' => '0'
	);

	foreach ( $defaults as $default => $value ) { // add defaults
		if ( ! @array_key_exists( $default, $atts ) ) { // mute warning with "@" when no params at all
			$atts[$default] = $value;
		}
	}

	$html = '<div id="crelate-iframe" style="text-align: center; -webkit-overflow-scrolling:touch; overflow: auto;">';
	$html .= '<iframe';
	foreach( $atts as $attr => $value ) {
		if ( strtolower($attr) == 'src' ) { // sanitize url
			$value = esc_url( $value );
		}
		if ( strtolower($attr) != 'same_height_as' AND strtolower($attr) != 'onload'
			AND strtolower($attr) != 'onpageshow' AND strtolower($attr) != 'onclick') { // remove some attributes
			if ( $value != '' ) { // adding all attributes
				$html .= ' ' . esc_attr( $attr ) . '="' . esc_attr( $value ) . '"';
			} else { // adding empty attributes
				$html .= ' ' . esc_attr( $attr );
			}
		}
	}
	$html .= '></iframe>'."\n";

	if ( isset( $atts["same_height_as"] ) ) {
		$html .= '
			<script>
			document.addEventListener("DOMContentLoaded", function(){
				var target_element, iframe_element;
				iframe_element = document.querySelector("iframe.' . esc_attr( $atts["class"] ) . '");
				target_element = document.querySelector("' . esc_attr( $atts["same_height_as"] ) . '");
				iframe_element.style.height = target_element.offsetHeight + "px";
			});
			</script>
		';
	}

	return $html;
}
add_shortcode( 'iframe', 'crelate_shortcode_add_shortcode_cb' );


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

