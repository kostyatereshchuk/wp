<?php

class Pulmone_Dropshipper_Mail_Parser
{

    /**
     * Get value after phraze and befoe separator
     */
    public function get_words_after_phrase($text, $phraze, $words_count = 1, $length = 20, $separator = ' ') {
        $phraze_pos = strpos( $text, $phraze );
        if ( $phraze_pos !== false ) {
            $words_pos = $phraze_pos + strlen($phraze);
            $text_length = strlen($text);
            $result = '';
            $found_words_count = 0;
            for ($i = $words_pos; $i < $text_length; $i++) {
                if ($text[$i] == $separator) {
                    $found_words_count++;
                }
                if ($found_words_count < $words_count) {
                    $result .= $text[$i];
                } else {
                    break;
                }
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Remove html tags and not used symbols from text
     */
    public function normalize_text($text)
    {
        $text = wp_strip_all_tags($text);
        $text = str_replace("\r", " ", $text);
        $text = str_replace("\n", " ", $text);
        $text = preg_replace("/ {2,}/", " ", $text);
        $text = str_replace("= ", "", $text);

        return $text;
    }

    /**
     * Check UPS notifications in gmail and update tracking information.
     */
    public function update_orders_tracking_data( ) {

        /* connect to gmail */
        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $username = 'pulmoneshipments@gmail.com';
        $password = '0523321099!';

        pulmone_dropshipper()->log( 'Connecting to ' . $username . ' ...' );
        
        try
        {
            $inbox = imap_open( $hostname, $username, $password );
        }
        catch(Exception $e)
        {
            $inbox = false;
            $imapErrors = implode("; ", imap_errors());
            $message = $e->getMessage() . "\n\nIMAP ERRORS: {$imapErrors}";
            
            pulmone_dropshipper()->log( $message );
            
            //throw new Exception($message);
        }

        if ( $inbox ) {

            $since = date('Y-m-d', intval(time() - 3600*24*7));

            $emails = imap_search($inbox,'FROM "UPS Quantum View" SINCE "' . $since . '"');

            $orders_tracking_data = array();
            if ($emails) {

                rsort($emails);

                foreach ( $emails as $email_number ) {
                    $overview = imap_fetch_overview($inbox,$email_number,0);
                    $message = imap_fetchbody($inbox,$email_number,2);
                    $subject = $overview[0]->subject;

                    if ( $tracking_number = $this->get_words_after_phrase( $subject, 'UPS Ship Notification, Tracking Number ' ) ) {
                        $message = $this->normalize_text($message);

                        $order_id = $this->get_words_after_phrase($message, 'Order #');

                        if (!$order_id) {
                            $order_id = $this->get_words_after_phrase($message, 'Order#');
                        }

                        if ($order_id) {
                            if ($date_shipped = $this->get_words_after_phrase($message, 'Scheduled Delivery:')) {
                                $date_shipped = date('Y-m-d', strtotime($date_shipped));
                            } else {
                                $date_shipped = '';
                            }

                            if ( !isset( $orders_tracking_data[$order_id] ) ) {
                                $orders_tracking_data[$order_id] = array();
                            }
                            $orders_tracking_data[$order_id][] = array(
                                'tracking_number' => $tracking_number,
                                'scheduled_delivery_date' => $date_shipped
                            );

                        }

                    }

                }

                $updated_orders_count = 0;

                foreach ( $orders_tracking_data as $order_id => $order_tracking_data ) {
                    $need_change = false;

                    if ($order = wc_get_order($order_id)) {



                        $dropshipper_tracking_data = get_post_meta( $order_id, 'dropshipper_tracking_data', 1 ) ;
                        
                        if ( !$dropshipper_tracking_data || ! is_array($dropshipper_tracking_data) ) {
                            $dropshipper_tracking_data = array();
                        }
                        
                        $new_dropshipper_tracking_data = $dropshipper_tracking_data;
                        
                        foreach ( $order_tracking_data as $index => $new_tracking_item ) {
                            $existed_tracking_number = false;
                            foreach ( $dropshipper_tracking_data as $index => $tracking_item ) {
                                if ( $tracking_item['tracking_number'] == $new_tracking_item['tracking_number'] ) {
                                    $existed_tracking_number = true;
                                    break;
                                }
                            }

                            if ( !$existed_tracking_number ) {
                                $need_change = true;

                                $new_dropshipper_tracking_data[] = $new_tracking_item;

                                pulmone_dropshipper()->log( 'Order #' . $order_id . ' | tracking_number: ' . $new_tracking_item['tracking_number'] . ' | scheduled_delivery_date: ' . $new_tracking_item['scheduled_delivery_date'] );
                            }
                        }

                        if ($need_change) {
                            pulmone_dropshipper()->update_tracking_data( $order_id, $new_dropshipper_tracking_data );



                            /*$wc = new WooCommerce;

                            $order = $wc->order_factory->get_order($order_id);*/

                            if ( $order->get_status() == 'processing' ) {

                                //update_post_meta( $order_id, '_need_order_update_status', 'completed' );

                                $complete_order_url = admin_url( 'admin-ajax.php' ) . '?action=set_order_completed&order_id=' . $order_id;

                                file_get_contents( $complete_order_url );


                                pulmone_dropshipper()->log( 'Updated order #' . $order_id . ' status to "Completed" | ' . $complete_order_url );

                                //$order->update_status( 'completed', '', true );
                                /*WC()->payment_gateways();
                                WC()->shipping();
                                WC()->mailer();
                                WC()->order_factory->get_order($order_id)->update_status( 'completed' );*/

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

                            $updated_orders_count++;
                        }
                    }
                }

                pulmone_dropshipper()->log( 'Updated orders count: ' . $updated_orders_count );


            }
            imap_close($inbox);

        } else {
            pulmone_dropshipper()->log( 'Cannot connect to Gmail: ' . imap_last_error() );
        }



        //exit;

    }

}