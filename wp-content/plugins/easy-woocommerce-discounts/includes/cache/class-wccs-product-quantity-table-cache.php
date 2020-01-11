<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WCCS_Product_Quantity_Table_Cache extends WCCS_Abstract_Cache {

    public function __construct() {
        parent::__construct( 'wccs_product_quantity_table_', 'wccs_product_quantity_table' );
    }

    public function get_quantity_table( array $args ) {
        if ( empty( $args ) ) {
            return false;
        }

        return get_transient( $this->get_transient_name( $args ) );
    }

    public function set_quantity_table( array $args, $table ) {
        if ( empty( $args ) ) {
            return false;
        }

        return set_transient( $this->get_transient_name( $args ), $table, DAY_IN_SECONDS * 30 );
    }

    public function get_transient_name( array $args = array() ) {
        if ( empty( $args ) ) {
            return false;
        }

        return $this->cache_prefix .
            md5(
                wp_json_encode( $args ) .
                ( ! empty( $args['product_id'] ) ? WC_Cache_Helper::get_transient_version( 'wccs-product-' . $args['product_id'] ) : '' ) .
                WC_Cache_Helper::get_transient_version( $this->cache_group ) .
                WC_Cache_Helper::get_transient_version( 'product' )
            );
    }

}
