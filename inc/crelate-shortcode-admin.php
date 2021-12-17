<?php
/**
 * Prevent direct access to the file.
 * @subpackage crelate-shortcode/inc/crelate-shortcode-admin.php
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * crelate-shortcode Options Page
 *
 * Add options page for the plugin.
 *
 * @since 1.0
 */
function crelate_shortcode_settings_plugin_page() {

	add_options_page(
		__( 'Crelate Options', 'crelate-shortcode' ),
		__( 'Crelate Editor', 'crelate-shortcode' ),
		'manage_options',
		'crelate-short',
		'crelate_shortcode_admin_page'
	);

}
add_action( 'admin_menu', 'crelate_shortcode_settings_plugin_page' );
add_action( 'admin_init', 'crelate_shortcode_register_admin_options' ); 
/**
 * Register settings for options page
 *
 * @since    1.0.0
 * 
 * a.) register all settings groups
 * Register Settings $option_group, $option_name, $sanitize_callback 
 */
function crelate_shortcode_register_admin_options() 
{
    
    register_setting( 'crelate_shortcode_options', 'crelate_shortcode_options' );
        
    //add a section to admin page
    add_settings_section(
        'crelate_shortcode_settings_section',
        '',
        'crelate_shortcode_settings_section_callback',
        'crelate_shortcode_options'
    );
        // c1.) settings 
    add_settings_field(
        'crelate_shortcode_url',
        esc_attr__('iFrame URL', 'unitizr'),
        'crelate_shortcode_url_cb',
        'crelate_shortcode_options',
        'crelate_shortcode_settings_section',
        array( 
            'type'         => 'text',
            'option_group' => 'crelate_shortcode_options', 
            'name'         => 'crelate_shortcode_url',
            'value'        => 
            esc_attr( get_option( 'crelate_shortcode_options' )['crelate_shortcode_url'] ),
            'description'  => esc_html__( 'The url of your Crelate iframe address', 'crelate-short'),
            'tip'          => esc_html__( 'JUST the part after src="....', 'crelate-short' )
        )
    );
}

/** 
 * render for '0' field
 * @since 1.0.0
 */
function crelate_shortcode_url_cb($args)
{  
    printf(
    '<fieldset><b class="grctip" data-title="%5$s">?</b><sup></sup>
    <p><span class="vmarg">%4$s </span></p>
    <input id="%1$s" class="text-field" name="%2$s[%1$s]" type="%6$s" value="%3$s"/>
    </fieldset>',
        $args['name'],
        $args['option_name'],
        $args['value'],
        $args['description'],
        $args['tip'],
        $args['type']
    );
}
//callback for description of options section
function crelate_shortcode_settings_section_callback() 
{
	echo '<h2>' . esc_html__( 'Crelate Shortcode Settings', '' ) . '</h2>';
}
// display the plugin settings page
function crelate_shortcode_admin_page()
{
	// check if user is allowed access
    if ( ! current_user_can( 'manage_options' ) ) return;
    
	print( '<form action="options.php" method="post">' );

	// output security fields
	settings_fields( 'crelate_shortcode_options' );

	// output setting sections
	do_settings_sections( 'crelate_shortcode_options' );
	submit_button();

    print( '</form>' ); 
    print('<h4>Tips</h4><div class="wide-fat"><p>'
        . esc_html_e( 'shortcode can be formatted as so on your content editor:', 'crelate-short' ) .'</p>
    <p>[crelate]</p>');
	
} 
