<?php

class Pulmone_Dropshipper_Tracking
{

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );
        add_action( 'save_post', array( $this, 'save_tracking_info' ), 10000, 3);
    }

    /**
     * Add Shipment Tracking metabox to order page.
     */
    public function add_meta_boxes( $post_type, $post ) {

        add_meta_box(
            'shipment_tracking',
            __( 'Shipment Tracking' ),
            array( $this, 'shipment_tracking_template' ),
            'shop_order',
            'side',
            'default'
        );
    }

    /**
     * Template for Shipment Tracking metabox.
     */
    function shipment_tracking_template() {

        $post_id = get_the_ID();

        if ($order = WC()->order_factory->get_order($post_id)) {

            wp_nonce_field("dropshipper", "dropshipper-nonce");

            $dropshipper_tracking_data = get_post_meta($post_id, 'dropshipper_tracking_data', 1);
            if (!$dropshipper_tracking_data || !is_array($dropshipper_tracking_data)) {
                $dropshipper_tracking_data = array(
                    array(
                        'tracking_number' => '',
                        'scheduled_delivery_date' => ''
                    )
                );
            }

            if ($order->get_status() == 'processing') {
                $is_empty_tracking_item = false;
                foreach ($dropshipper_tracking_data as $tracking_item) {
                    if (!$tracking_item['tracking_number']) {
                        $is_empty_tracking_item = true;
                        break;
                    }
                }

                if (!$is_empty_tracking_item) {
                    $dropshipper_tracking_data[] = array(
                        'tracking_number' => '',
                        'scheduled_delivery_date' => ''
                    );
                }
            }

            ?>

            <p>
                Provider: <strong>UPS Worldship</strong>
            </p>

            <?php foreach ($dropshipper_tracking_data as $index => $tracking_item): ?>

                <hr>

                <p>
                    <label for="dropshipper_tracking_number<?php echo $index ?>">Tracking number:</label>
                    <input type="text" name="dropshipper_tracking_data[<?php echo $index ?>][tracking_number]" id="dropshipper_tracking_number<?php echo $index ?>" class="input-text full-width" value="<?php echo $tracking_item['tracking_number'] ?>">
                </p>
                <p>
                    <label for="dropshipper_date_shipped<?php echo $index ?>">Scheduled delivery date:</label>
                    <input type="date" name="dropshipper_tracking_data[<?php echo $index ?>][scheduled_delivery_date]" id="dropshipper_date_shipped<?php echo $index ?>" class="input-text full-width" value="<?php echo $tracking_item['scheduled_delivery_date'] ?>">
                </p>
                <?php if ($tracking_item['tracking_number']): ?>
                    <p>
                        <a href="<?php echo pulmone_dropshipper()->get_tracking_url($tracking_item['tracking_number']) ?>" target="_blank">Click here to track your shipment</a>
                    </p>
                <?php endif; ?>

            <?php endforeach; ?>

            <?php

        }


    }

    /**
     * Save Shipment Tracking metabox.
     */
    function save_tracking_info($post_id, $post, $update)
    {

        if (!isset($_POST["dropshipper-nonce"]) || !wp_verify_nonce($_POST["dropshipper-nonce"], "dropshipper")) return $post_id;
        if (!current_user_can("edit_post", $post_id)) return $post_id;
        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) return $post_id;
        if ($post->post_type != "shop_order") return $post_id;



        if (isset($_POST['dropshipper_tracking_data'])) {
            $dropshipper_tracking_data = $_POST['dropshipper_tracking_data'];

            if (!$dropshipper_tracking_data || !is_array($dropshipper_tracking_data)) {
                $dropshipper_tracking_data = array();
            }

            $new_dropshipper_tracking_data = array();
            foreach ( $dropshipper_tracking_data as $index => $tracking_item ) {
                if ($tracking_item['tracking_number']) {
                    $new_dropshipper_tracking_data[$index] = array(
                        'tracking_number' => sanitize_text_field( $tracking_item['tracking_number'] ),
                        'scheduled_delivery_date' => $tracking_item['scheduled_delivery_date'] ? date( 'Y-m-d', strtotime( $tracking_item['scheduled_delivery_date'] ) ) : ''
                    );
                }
            }

            pulmone_dropshipper()->update_tracking_data( $post_id, $new_dropshipper_tracking_data );

        }


    }

}

new Pulmone_Dropshipper_Tracking();