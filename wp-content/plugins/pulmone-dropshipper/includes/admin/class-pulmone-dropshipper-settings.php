<?php

class Pulmone_Dropshipper_Settings
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
            'Pulmone Dropshipper',
            'Pulmone Dropshipper',
            'manage_options',
            'pulmone-dropshipper',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'pulmone_dropshipper' );
        ?>
        <div class="wrap">
            <h1>Pulmone Dropshipper</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'pulmone_dropshipper_options_group' );
                do_settings_sections( 'pulmone-dropshipper' );
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
            'pulmone_dropshipper_options_group', // Option group
            'pulmone_dropshipper', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'pulmone_dropshipper_settings', // ID
            'Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'pulmone-dropshipper' // Page
        );

        add_settings_field(
            'dropshipper_email', // ID
            'Dropshipper Email', // Title
            array( $this, 'dropshipper_email_callback' ), // Callback
            'pulmone-dropshipper', // Page
            'pulmone_dropshipper_settings' // Section
        );

        add_settings_field(
            'dropshipper_products',
            'Dropshipper Products',
            array( $this, 'dropshipper_products_callback' ),
            'pulmone-dropshipper',
            'pulmone_dropshipper_settings'
        );
    }

    /**
     * Sanitize each setting field as needed
     *

     */
    public function sanitize( $input )
    {

        if ( isset( $input['dropshipper_email'] ) ) {
            //$input['dropshipper_email'] = filter_var($input['dropshipper_email'], FILTER_VALIDATE_EMAIL) ? $input['dropshipper_email'] : '';
            $input['dropshipper_email'] = sanitize_text_field($input['dropshipper_email']);
        }

        if ( isset( $input['dropshipper_products'] ) ) {

            $input['dropshipper_products'] = is_array($input['dropshipper_products']) ? $input['dropshipper_products'] : array();


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
    public function dropshipper_email_callback()
    {
        $value = isset( $this->options['dropshipper_email'] ) ? esc_attr( $this->options['dropshipper_email']) : '';
        ?>

        <input type="text" id="dropshipper_email" name="pulmone_dropshipper[dropshipper_email]" value="<?php echo $value ?>" style="min-width: 50%" />

        <?php
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function dropshipper_products_callback()
    {

        $dropshipper_products = isset( $this->options['dropshipper_products'] ) ? $this->options['dropshipper_products'] : array();

        $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'title',
            'order'            => 'ASC',
            'post_type'        => 'product',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $products = get_posts($args);

        if (count($products)) {
            ?>

            <select name="pulmone_dropshipper[dropshipper_products][]" id="dropshipper_products" multiple>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product->ID ?>"<?php echo in_array($product->ID, $dropshipper_products) ? ' selected' : '' ?>><?php echo $product->post_title ?></option>
                <?php endforeach; ?>
            </select>

            <?php
        }

    }
}

new Pulmone_Dropshipper_Settings();