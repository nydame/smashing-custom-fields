<?php

defined( 'ABSPATH' ) or die( 'Nice try!' );

if ( ! class_exists(Firefly_Fields_Plugin) ):

class Firefly_Fields_Plugin {

    /**
     * Provide static variable to enforce singleton pattern
     * 
     * @var Object Instance of this class
     *
     * @since   0.0.3
     */
    private static $instance;

    public static function get_instance() {
        if( null == self::$instance ) {
            self::$instance = new self; // i.e., new Firefly_Fields_Plugin()
        }
        return self::$instance;
    }

    public function __construct() {
    	// Hook into the admin menu
    	add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ));

        // Add Settings and Fields
    	add_action( 'admin_init', array( $this, 'setup_sections' ) );
    	add_action( 'admin_init', array( $this, 'setup_fields' ) );

        add_action('init', array( $this, 'implement_feature_1' ));
    }

    public function create_plugin_settings_page() {
        // Add the menu item and page
        $page_title = 'Firefly Plugin Settings Page';
        $menu_title = 'Firefly Plugin';
        $capability = 'manage_options';
        $slug = 'firefly_fields';
        $callback = array( $this, 'plugin_settings_page_content' );
        $icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHdpZHRoPSIyNDYuNzY4cHgiIGhlaWdodD0iMTcxLjQ4M3B4IiB2aWV3Qm94PSIwIDAgMjQ2Ljc2OCAxNzEuNDgzIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAyNDYuNzY4IDE3MS40ODMiDQoJIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGcgaWQ9ImJhc2UiPg0KCQ0KCQk8cmFkaWFsR3JhZGllbnQgaWQ9Imdsb3dfMV8iIGN4PSI2MC40NDA5IiBjeT0iODguNzMiIHI9IjU2LjgxMDMiIGdyYWRpZW50VHJhbnNmb3JtPSJtYXRyaXgoMC45MjQgLTAuMzgyNCAwLjM4MjQgMC45MjQgLTIzLjc4MDYgNTQuNTUwNCkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj4NCgkJPHN0b3AgIG9mZnNldD0iMCIgc3R5bGU9InN0b3AtY29sb3I6I0Y5RUQzMiIvPg0KCQk8c3RvcCAgb2Zmc2V0PSIxIiBzdHlsZT0ic3RvcC1jb2xvcjojRkZGRkZGIi8+DQoJPC9yYWRpYWxHcmFkaWVudD4NCgk8cGF0aCBpZD0iZ2xvdyIgZmlsbD0idXJsKCNnbG93XzFfKSIgZD0iTTEyMC45NTQsOTAuNjc1YzExLjQwOSwyNy41NjMtMy45NTMsNjAuMDktMzQuMzA1LDcyLjY1Mg0KCQljLTMwLjM1NSwxMi41NjItNjQuMjA3LDAuNC03NS42MTMtMjcuMTYyYy0xMS40MDQtMjcuNTU5LDMuOTUzLTYwLjA4NCwzNC4zMDctNzIuNjQ2Qzc1LjY5Nyw1MC45NTgsMTA5LjU0OSw2My4xMTcsMTIwLjk1NCw5MC42NzUNCgkJeiIvPg0KCTxwYXRoIGlkPSJib2R5IiBvcGFjaXR5PSIwLjc1IiBmaWxsPSIjRDNEMUJDIiBzdHJva2U9IiNBOEE3ODgiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgZD0iTTIzOC41Nyw4Mi44NDgNCgkJYzYuODU3LDI4LjUwNS0yNi40NjcsNjAuOTY2LTc0LjQzNCw3Mi41MDJjLTQ3Ljk2OSwxMS41MzgtOTIuNDExLTIuMjEyLTk5LjI2Ny0zMC43MTZjLTYuODU4LTI4LjUwMSwyNi40NjktNjAuOTYyLDc0LjQzNy03Mi41MDENCgkJQzE4Ny4yNzUsNDAuNTk0LDIzMS43MTIsNTQuMzQ2LDIzOC41Nyw4Mi44NDh6Ii8+DQoJPHBhdGggaWQ9ImJ1dHQiIGZpbGw9IiNGN0Y1QUQiIGQ9Ik0xMTIuMDM2LDYxLjU3OWMtMzIuNjA3LDE1LjE1NC01Mi42MjksNDAuMzU4LTQ3LjE2Nyw2My4wNTYNCgkJYzIuNTU0LDEwLjYxNywxMC4zMjMsMTkuMTg0LDIxLjU0OSwyNS4xNjRjNS4xODctMTguOTQ1LDEwLjUxOC0zNS44MDksMTUuNjk2LTU0Ljg1NEMxMDUuMzgsODIuNjkyLDEwOS43NTIsNzMuMTE3LDExMi4wMzYsNjEuNTc5DQoJCXoiLz4NCgk8cGF0aCBpZD0iYm9keV9zaGFkb3ciIG9wYWNpdHk9IjAuMSIgZmlsbD0iIzk5OTk5OSIgZD0iTTI0My43NTUsODcuNzgzYzYuODU3LDI4LjUwMS0yNi40NjcsNjAuOTYxLTc0LjQzNCw3Mi40OTgNCgkJYy00Ny45NjYsMTEuNTM5LTkyLjQwOS0yLjIxMS05OS4yNjQtMzAuNzE1Yy02Ljg1OS0yOC41MDIsMjYuNDY3LTYwLjk2MSw3NC40MzQtNzIuNUMxOTIuNDYsNDUuNTI2LDIzNi45MDIsNTkuMjc4LDI0My43NTUsODcuNzgzDQoJCXoiLz4NCgk8cGF0aCBpZD0ibGVmdF93aW5nX3NoYWRvdyIgb3BhY2l0eT0iMC4xIiBmaWxsPSIjOTk5OTk5IiBkPSJNMTU5LjAzNyw4MS43MTVjNy44MzQtMS4zMDksMC41NTUtOS45LTEwLjIyNy00Mi4xODYNCgkJQzEzOC4wMjcsNy4yNDUsMTIxLjU1MiwzLjc0NywxMTQuMDAzLDguODA2Yy03LjU0Nyw1LjA1Ny00LjIyNSwzMy4zMzksMi45ODksNDQuNTM2QzEyNC4yMDUsNjQuNTQsMTUxLjE5Nyw4My4wMjUsMTU5LjAzNyw4MS43MTV6DQoJCSIvPg0KCTxwYXRoIGlkPSJyaWdodF93aW5nX3NoYWRvdyIgb3BhY2l0eT0iMC4xIiBmaWxsPSIjOTk5OTk5IiBkPSJNMTYxLjU4Myw3OS4wN2MzLjY1OCw3LjA1Ni03LjU4NCw2LjM4OS0zOS44ODEsMTcuMTQyDQoJCWMtMzIuMjk1LDEwLjc1MS00NC45NzktMC4zMy00NS40NjUtOS40MDFjLTAuNDg0LTkuMDcyLDI0LjEzMy0yMy4zODgsMzcuNDE5LTI0LjM0QzEyNi45NDEsNjEuNTIxLDE1Ny45MjcsNzIuMDE0LDE2MS41ODMsNzkuMDd6Ig0KCQkvPg0KCQ0KCQk8bGluZSBkaXNwbGF5PSJub25lIiBvcGFjaXR5PSIwLjEiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzAwMDAwMCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiB4MT0iNDguMzI3IiB5MT0iMTA3LjU4MyIgeDI9IjE0LjU1IiB5Mj0iOTguMjYxIi8+DQoJDQoJCTxsaW5lIGRpc3BsYXk9Im5vbmUiIG9wYWNpdHk9IjAuMSIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMDAwMDAwIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHgxPSI2My45NTIiIHkxPSI4Ny41MDkiIHgyPSI0MS45MTgiIHkyPSI1OS4zMjMiLz4NCgkNCgkJPGxpbmUgZGlzcGxheT0ibm9uZSIgb3BhY2l0eT0iMC4xIiBmaWxsPSJub25lIiBzdHJva2U9IiMwMDAwMDAiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgeDE9IjUxLjM1MSIgeTE9IjEzNy4zODEiIHgyPSIyNC43MjYiIHkyPSIxNTQuNzU5Ii8+DQoJPHBhdGggZGlzcGxheT0ibm9uZSIgb3BhY2l0eT0iMC4xIiBmaWxsPSJub25lIiBzdHJva2U9IiMwMDAwMDAiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgZD0iTTE5Mi4wNTQsMTIwLjUzMw0KCQljMCwwLDI0LjcxNSwxMS4xMDgsMzUuNDA2LTguNzEiLz4NCgk8bGluZSBmaWxsPSJub25lIiBzdHJva2U9IiNBOEE3ODgiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgeDE9IjQ0Ljc1MyIgeTE9IjEwOC40NTIiIHgyPSIxLjcxNCIgeTI9IjEwOC43MjQiLz4NCgk8bGluZSBmaWxsPSJub25lIiBzdHJva2U9IiNBOEE3ODgiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgeDE9IjUxLjI5MiIgeTE9Ijg0Ljg2OSIgeDI9IjIyLjM4NiIgeTI9IjYzLjc4NSIvPg0KCTxsaW5lIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0E4QTc4OCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiB4MT0iNDkuNjc0IiB5MT0iMTMyLjM1MSIgeDI9IjE5LjQiIHkyPSIxNTEuNDE4Ii8+DQoJPHBhdGggZmlsbD0ibm9uZSIgc3Ryb2tlPSIjQThBNzg4IiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIGQ9Ik0xODYuMjI0LDExNi4zNjdjMCwwLDI0LjcxMywxMS4xMTEsMzUuNDA2LTguNzA5Ii8+DQoJPGcgaWQ9ImxlZnRfZXllXzFfIj4NCgkJPHBhdGggZmlsbD0iI0E4QTc4OCIgc3Ryb2tlPSIjQThBNzg4IiBkPSJNMjIzLjMzNSw4Mi40NTVjMC4yNjYsMC42MzksMC4yNywxLjQwNSwwLjAxLDIuMjk0DQoJCQljLTAuMjU2LDAuODkyLTAuNjkzLDEuNjYyLTEuMzAzLDIuMzE0bC0wLjU3Ni0wLjQxN2MwLjIwMS0wLjI0MywwLjM4MS0wLjQ4OCwwLjU0OS0wLjc0MWMwLjE2LTAuMjUyLDAuMjg3LTAuNTE5LDAuMzc5LTAuODA1DQoJCQljMC4wOTItMC4yOTYsMC4xNDgtMC41OCwwLjE1Ni0wLjg1NGMwLjAxOC0wLjI3Mi0wLjAzMy0wLjU3OC0wLjE0NS0wLjkxOGwtMC40NDEsMC4xODFjLTAuNTMzLDAuMjIyLTAuOTg4LDAuMjY4LTEuMzYzLDAuMTM5DQoJCQljLTAuMzY3LTAuMTI5LTAuNjQ1LTAuNDA0LTAuODItMC44MzFjLTAuMTM5LTAuMzM1LTAuMTM1LTAuNjk1LDAuMDItMS4wN2MwLjE1LTAuMzgyLDAuNDE0LTAuNjQ5LDAuNzk5LTAuODA3DQoJCQljMC41ODYtMC4yNDMsMS4xMTctMC4yMjYsMS41OTIsMC4wNDZDMjIyLjY2NCw4MS4yNjUsMjIzLjA0Miw4MS43NTEsMjIzLjMzNSw4Mi40NTV6Ii8+DQoJPC9nPg0KCTxnIGlkPSJyaWdodF9leWVfMV8iPg0KCQk8cGF0aCBmaWxsPSIjQThBNzg4IiBzdHJva2U9IiNBOEE3ODgiIGQ9Ik0xOTcuNzMyLDg0Ljk0NGMwLjI2NiwwLjY0MywwLjI2OCwxLjQwOCwwLjAxLDIuMjk1DQoJCQljLTAuMjU4LDAuODkzLTAuNjg5LDEuNjYxLTEuMjk3LDIuMzEzbC0wLjU3OC0wLjQxNGMwLjIwMS0wLjI0MywwLjM4My0wLjQ5MSwwLjU0My0wLjc0MmMwLjE2NC0wLjI1MSwwLjI5My0wLjUxOSwwLjM4My0wLjgwNA0KCQkJYzAuMDk0LTAuMjk2LDAuMTQ2LTAuNTgsMC4xNTgtMC44NTRjMC4wMTQtMC4yNy0wLjAzNy0wLjU4LTAuMTQ2LTAuOTE5TDE5Ni4zNjMsODZjLTAuNTM1LDAuMjIxLTAuOTg4LDAuMjY3LTEuMzYxLDAuMTQxDQoJCQljLTAuMzczLTAuMTI5LTAuNjQ4LTAuNDA3LTAuODIyLTAuODMyYy0wLjEzOS0wLjMzNi0wLjEzNy0wLjY5NCwwLjAxOC0xLjA3MmMwLjE0OC0wLjM3OCwwLjQxOC0wLjY0OSwwLjgwMy0wLjgwNQ0KCQkJYzAuNTg2LTAuMjQ2LDEuMTE3LTAuMjI4LDEuNTg4LDAuMDQ0QzE5Ny4wNiw4My43NTQsMTk3LjQ0MSw4NC4yNDEsMTk3LjczMiw4NC45NDR6Ii8+DQoJPC9nPg0KCTxwYXRoIGlkPSJsZWZ0X3dpbmciIGZpbGw9Im5vbmUiIHN0cm9rZT0iI0E4QTc4OCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNMTUzLjg0OSw3Ni43ODNjNy44MzYtMS4zMDYsMC41NTUtOS45LTEwLjIyNy00Mi4xODUNCgkJQzEzMi44MzksMi4zMTMsMTE2LjM2Ni0xLjE4NCwxMDguODE3LDMuODczYy03LjU0OSw1LjA1OS00LjIyNiwzMy4zMzksMi45ODYsNDQuNTM4QzExOS4wMTUsNTkuNjA4LDE0Ni4wMDksNzguMDk0LDE1My44NDksNzYuNzgzDQoJCXoiLz4NCgk8cGF0aCBpZD0icmlnaHRfd2luZyIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjQThBNzg4IiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIGQ9Ik0xNTYuMzk2LDc0LjE0DQoJCWMzLjY1Niw3LjA1NC03LjU4Niw2LjM4NS0zOS44NzksMTcuMTM5Yy0zMi4yOTcsMTAuNzU0LTQ0Ljk4LTAuMzI2LTQ1LjQ2Ny05LjM5OGMtMC40ODMtOS4wNzIsMjQuMTMzLTIzLjM4OCwzNy40MTgtMjQuMzQNCgkJQzEyMS43NTMsNTYuNTg5LDE1Mi43NDIsNjcuMDgzLDE1Ni4zOTYsNzQuMTR6Ii8+DQo8L2c+DQo8ZyBpZD0iYmlnX2V5ZXMiPg0KCTxjaXJjbGUgZmlsbD0iI0ZGRkZGRiIgc3Ryb2tlPSIjQThBNzg4IiBjeD0iMTk0LjQxOCIgY3k9Ijg3LjA0OSIgcj0iMTAiLz4NCgk8Y2lyY2xlIGZpbGw9IiNGRkZGRkYiIHN0cm9rZT0iI0E4QTc4OCIgY3g9IjIyMS43NTciIGN5PSI4NC43MzYiIHI9IjEwIi8+DQoJPGNpcmNsZSBjeD0iMTk2LjE0NCIgY3k9Ijg0LjkzIiByPSI1Ii8+DQoJPGNpcmNsZSBjeD0iMjIyLjc0OCIgY3k9IjgyLjQ0MiIgcj0iNSIvPg0KPC9nPg0KPGcgaWQ9Im9wZW5fbW91dGgiPg0KCTxwYXRoIGZpbGw9IiNGRkZGRkYiIHN0cm9rZT0iI0E4QTc4OCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNMTg2LjIyNCwxMTYuMzY3YzAsMCwyNC43MTMsMTEuMTExLDM1LjQwNi04LjcwOSIvPg0KPC9nPg0KPC9zdmc+DQo=';
        $position = 100;

        add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
    }

    public function plugin_settings_page_content() { ?>
    	<div class="wrap">
    		<h2>My Awesome Settings Page</h2>
    		<form method="POST" action="options.php">
                <?php
                    settings_fields( 'firefly_fields' );
                    do_settings_sections( 'firefly_fields' );
                    submit_button();
                ?>
    		</form>
    	</div> <?php
    }

    public function setup_sections() {
        add_settings_section( 'section_1', 'Top Section', array( $this, 'section_callback' ), 'firefly_fields' );
        add_settings_section( 'section_2', 'Bottom Section', array( $this, 'section_callback' ), 'firefly_fields' );
    }

    public function section_callback( $arguments ) {
    	switch( $arguments['id'] ){
    		case 'section_1':
    			echo 'You can turn shortcodes on and off in this section.';
    			break;
    		case 'section_2':
    			echo 'Here is where you can set the background color of your favorite DOM elements.';
    			break;
    	}
    }

    /**
     * Determines which form fields will be shown on the plugin's settings page(s) on the Dashboard.
     * @since 0.1.0
     * @uses add_settings_field 
     * @uses register_setting 
     */
    public function setup_fields() {
        $fields = array(
        	array(
        		'uid' => 'add_widget_shortcodes',
        		'label' => 'Enable widget shortcodes?',
        		'section' => 'section_1',
        		'type' => 'radio',
        		'options' => array(
        			'option1' => 'Yes',
        			'option2' => 'No',
        		),
                'default' => ''
        	),
        	array(
        		'uid' => 'color_picker_color',
        		'label' => 'Choose background color for tag',
        		'section' => 'section_2',
        		'type' => 'color',
                'default' => ''
        	),
            array(
                'uid' => 'color_picker_tag_name',
                'label' => 'Choose HTML tag to get background color applied',
                'section' => 'section_2',
                'type' => 'select',
                'options' => array(
                    'option1' => 'body',
                    'option2' => 'div',
                    'option3' => 'a',
                    'option4' => 'p',
                    'option5' => 'article',
                ),
                'default' => ''
            ),
        );
    	foreach( $fields as $field ) {

        	add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), 'firefly_fields', $field['section'], $field );
            register_setting( 'firefly_fields', $field['uid'] );
    	}
    }

    public function field_callback( $arguments ) {

        $value = get_option( $arguments['uid'] );

        if( ! $value ) {
            $value = $arguments['default'];
        }

        switch( $arguments['type'] ){
            case 'text':
            case 'password':
            case 'number':
                printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
                break;
            case 'textarea':
                printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $arguments['placeholder'], $value );
                break;
            case 'select':
            case 'multiselect':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $attributes = '';
                    $options_markup = '';
                    foreach( $arguments['options'] as $key => $label ){
                        $options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value[ array_search( $key, $value, true ) ], $key, false ), $label );
                    }
                    if( $arguments['type'] === 'multiselect' ){
                        $attributes = ' multiple="multiple" ';
                    }
                    printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $arguments['uid'], $attributes, $options_markup );
                }
                break;
            case 'radio':
            case 'checkbox':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $options_markup = '';
                    $iterator = 0;
                    foreach( $arguments['options'] as $key => $label ){
                        $iterator++;
                        $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $arguments['type'], $key, checked( $value[ array_search( $key, $value, true ) ], $key, false ), $label, $iterator );
                    }
                    printf( '<fieldset>%s</fieldset>', $options_markup );
                }
                break;
            case 'color':
                printf('<input name="%1$s" id="%1$s" type="%2$s" />', $arguments['uid'], $arguments['type']);
                break;
        }

        if( $helper = $arguments['helper'] ){
            printf( '<span class="helper"> %s</span>', $helper );
        }

        if( $supplimental = $arguments['supplimental'] ){
            printf( '<p class="description">%s</p>', $supplimental );
        }

    }

    public function implement_feature_1() {
        // implement feature Add Shortcode to Widgets
        $add_widget_shortcodes = get_option('add_widget_shortcodes');
        if ( ! empty($add_widget_shortcodes) && $add_widget_shortcodes == "option1" ) {
            add_action('widget_text', 'do_shortcode');
        }
    }

}

endif;