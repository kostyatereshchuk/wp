<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCCS_Product_Validator {

	protected $customer;

	public function __construct( $customer = null ) {
		$this->customer  = ! is_null( $customer ) ? new WCCS_Customer( $customer ) : new WCCS_Customer( wp_get_current_user() );
	}

	public function is_valid_product( array $items, $product_id, $variation_id = 0, array $variation = array() ) {
		if ( empty( $items ) ) {
			return false;
		}

		foreach ( $items as $item ) {
			if ( ! $this->is_valid( $item, $product_id, $variation_id, $variation ) ) {
				return false;
			}
		}

		return true;
	}

	public function is_valid( $item, $product_id, $variation_id = 0, array $variation = array() ) {
		if ( empty( $item ) ) {
			return false;
		}

		$method = '';
		if ( isset( $item['item'] ) ) {
			$method = $item['item'];
		} elseif ( isset( $item['condition'] ) ) {
			$method = $item['condition'];
		}

		$method = apply_filters( 'wccs_product_validator_validate_method', $method, $item, $product_id, $variation_id, $variation );
		if ( empty( $method ) ) {
			return false;
		}

		$is_valid = false;
		if ( method_exists( $this, $method ) ) {
			$is_valid = $this->{$method}( $item, $product_id, $variation_id, $variation );
		}

		return apply_filters( 'wccs_product_validator_is_valid', $is_valid, $item, $product_id, $variation_id, $variation );
	}

	public function all_products( $item, $product_id, $variation_id = 0, array $variation = array() ) {
		return $product_id > 0;
	}

	public function products_in_list( $item, $product_id, $variation_id = 0, array $variation = array() ) {
		if ( empty( $item['products'] ) ) {
			return false;
		}

		return in_array( $product_id, $item['products'] );
	}

	public function categories_in_list( $item, $product_id, $variation_id = 0, array $variation = array() ) {
		if ( empty( $item['categories'] ) ) {
			return false;
		}

		return in_array( $product_id, WCCS()->products->get_categories_products( $item['categories'] ) );
	}

}
