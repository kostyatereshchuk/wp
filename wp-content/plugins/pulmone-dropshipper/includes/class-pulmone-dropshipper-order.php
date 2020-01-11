<?php

class Pulmone_Dropshipper_Order
{

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'woocommerce_view_order', array( $this, 'add_order_tracking' ), 10000 );
        add_action( 'woocommerce_email_after_order_table', array( $this, 'add_order_tracking_to_email' ), 10000 );

        add_action( 'woocommerce_order_status_pending_to_processing', array( $this, 'send_email_to_dropshipper' ), 10000 );

        add_action( 'wp_ajax_set_order_completed', array( $this, 'set_order_completed' ) );
        add_action( 'wp_ajax_nopriv_set_order_completed', array( $this, 'set_order_completed' ) );
    }

    /**
     * Ajax change order status to "Completed".
     */
    public function set_order_completed( ) {

        $order_id = isset( $_REQUEST['order_id'] ) ? intval( $_REQUEST['order_id'] ) : 0;

        if ( $order_id ) {
            if ( $order = WC()->order_factory->get_order( $order_id ) ) {
                if ( $order->get_status() != 'completed' ) {
                    $order->update_status( 'completed', '', true );

                    //$order->update_status( 'completed' );

                    /*WC()->payment_gateways();
                    WC()->shipping();*/

                    /*$mailer = WC()->mailer();
                    $mails = $mailer->get_emails();
                    if ( ! empty( $mails ) ) {
                        foreach ( $mails as $mail ) {
                            if ( $mail->id == 'customer_completed_order' ) {
                                $mail->trigger( $order->id );
                            }
                        }
                    }*/
                }
            }
        }

        exit;

    }

    /**
     * Add Shipment Tracking info to view order.
     */
    public function add_order_tracking( $order_id ) {

        $dropshipper_tracking_data = get_post_meta( $order_id, 'dropshipper_tracking_data', 1 );

        if (is_array($dropshipper_tracking_data) && count($dropshipper_tracking_data)) {
            echo '<p>';
            echo 'Your order was shipped via <strong>UPS Worldship</strong>.';
            echo '</p>';
            foreach ( $dropshipper_tracking_data as $index => $tracking_item ) {
                echo '<p>';
                echo 'Tracking number <span>' . $tracking_item['tracking_number'] . '</span>.';
                if ($tracking_item['scheduled_delivery_date']) {
                    echo ' Scheduled delivery date is ' . date( 'F d, Y', strtotime( $tracking_item['scheduled_delivery_date'] ) ) . '.';
                }
                echo ' <a href="' . pulmone_dropshipper()->get_tracking_url($tracking_item['tracking_number']) . '" target="_blank">Click here to track your shipment</a>.';
                echo '</p>';
            }

        }
    }

    /**
     * Add Shipment Tracking info to order email.
     */
    public function add_order_tracking_to_email( $order ) {

        $order_id = $order->post->ID;;

        $dropshipper_tracking_data = get_post_meta( $order_id, 'dropshipper_tracking_data', 1 );

        $packages_count = count($dropshipper_tracking_data);
        if (is_array($dropshipper_tracking_data) && $packages_count) {
            echo '<h2>Delivery Details</h2>';
            echo '<p>';
            echo 'Your order was shipped via <strong>UPS Worldship</strong>. You should be expecting ' . $packages_count . ' ' . ( $packages_count > 1 ? 'packages' : 'package' ) . ':';
            echo '</p>';
            foreach ( $dropshipper_tracking_data as $index => $tracking_item ) {
                echo '<p>';
                echo 'Tracking number <span>' . $tracking_item['tracking_number'] . '</span>.';
                if ($tracking_item['scheduled_delivery_date']) {
                    echo ' Scheduled delivery date is ' . date( 'F d, Y', strtotime( $tracking_item['scheduled_delivery_date'] ) ) . '.';
                }
                echo ' <a href="' . pulmone_dropshipper()->get_tracking_url($tracking_item['tracking_number']) . '" target="_blank">Click here to track your shipment</a>.';
                echo '</p>';
            }

        }
    }

    /**
     * Send email with order details to dropshipper.
     */
    public function send_email_to_dropshipper( $order_id ) {

        $dropshipper = get_option( 'pulmone_dropshipper' );
        $dropshipper_products = $dropshipper['dropshipper_products'];
        $dropshipper_email = $dropshipper['dropshipper_email'];

        $order = WC()->order_factory->get_order($order_id);



        if ( $order && $dropshipper_products ) {

            $order_items = $order->get_items();

            $dropshipper_order_items = array();

            foreach ($order_items as $item_id => $item) {
                if ( in_array( $item['product_id'], $dropshipper_products ) ) {
                    $dropshipper_order_items[$item_id] = $item;
                }
            }

            if ( count($dropshipper_order_items) ) {

                $subject = '[PulmOne] New customer order #' . $order_id . ' - ' . date_i18n( wc_date_format(), strtotime( $order->order_date ) );

                ob_start();

                ?>

                <h2>
                    Order #<?php echo $order_id ?> <time datetime="<?php echo date_i18n( 'c', strtotime( $order->order_date ) ) ?>" style="font-weight: 100"><?php echo date_i18n( wc_date_format(), strtotime( $order->order_date ) ) ?></time>
                </h2>

                <table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
                    <thead>
                    <tr>
                        <th class="td" scope="col" style="text-align:left;"><?php _e( 'Product', 'woocommerce' ); ?></th>
                        <th class="td" scope="col" style="text-align:left;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
                    </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($dropshipper_order_items as $item_id => $item): ?>

                            <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
                                <td class="td" style="text-align:left; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word;"><?php

                                    // Product name
                                    echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item, false );

                                    ?>
                                </td>
                                <td class="td" style="text-align:left; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
                                    <?php echo apply_filters( 'woocommerce_email_order_item_quantity', $item['qty'], $item ); ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

                <?php /* ?>
                <h2><?php _e( 'Customer details', 'woocommerce' ); ?></h2>
                <ul>
                    <li>
                        <strong>Tel:</strong> <span class="text"><?php echo wp_kses_post( $order->billing_phone ); ?></span>
                    </li>
                </ul>
                <?php */ ?>

                <table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top;" border="0">
                    <tr>

                        <?php if (  $shipping = $order->get_formatted_shipping_address()  ): ?>
                            <td class="td" style="text-align:left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border: none;" valign="top" width="100%" border="0">
                                <h3><?php _e( 'Shipping address', 'woocommerce' ); ?></h3>

                                <p class="text"><?php echo $shipping; ?></p>
                                <p><strong>Tel:</strong> <span class="text"><?php echo wp_kses_post( $order->billing_phone ); ?></span></p>
                            </td>
                        <?php endif; ?>
                    </tr>
                </table>

                <?php

                $message = ob_get_clean();


                //$new_order_settings = get_option( 'woocommerce_new_order_settings', array() );
                $mailer             = WC()->mailer();
                $message            = $mailer->wrap_message( $subject, $message );
                //$mailer->send( ! empty( $new_order_settings['recipient'] ) ? $new_order_settings['recipient'] : get_option( 'admin_email' ), strip_tags( $subject ), $message );
                $mailer->send( $dropshipper_email, strip_tags( $subject ), $message );

                pulmone_dropshipper()->log( 'Message to dropshipper has been sent. | Order #' . $order_id );

            }

        }

    }

}

new Pulmone_Dropshipper_Order();