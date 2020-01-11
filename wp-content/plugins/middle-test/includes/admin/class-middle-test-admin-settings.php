<?php

class Middle_Test_Admin_Settings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        add_options_page(
            'Middle Test Settings',
            'Middle Test Settings',
            'manage_options',
            'middle-test',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'middle_test' );
        ?>
        <div class="wrap">
            <h1>Middle test</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'middle_test_options_group' );
                do_settings_sections( 'middle-test' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'middle_test_options_group', // Option group
            'middle_test', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'middle_test_settings', // ID
            'Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'middle-test' // Page
        );

        add_settings_field(
            'text_field', // ID
            'Text Field', // Title
            array( $this, 'text_field_callback' ), // Callback
            'middle-test', // Page
            'middle_test_settings' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     */
    public function sanitize( $input )
    {
        if ( isset( $input['text_field'] ) ) {
            $input['text_field'] = sanitize_text_field($input['text_field']);
        }

        return $input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function text_field_callback()
    {
        $value = isset( $this->options['text_field'] ) ? esc_attr( $this->options['text_field']) : '';
        ?>

        <input type="text" id="text_field" name="middle_test[text_field]" value="<?php echo $value ?>" style="min-width: 50%" />

        <?php
    }
}

new Middle_Test_Admin_Settings();