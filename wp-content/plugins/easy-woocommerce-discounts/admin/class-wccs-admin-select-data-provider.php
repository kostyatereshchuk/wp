<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCCS_Admin_Select_Data_Provider {

	public function get_products( array $args = array() ) {
		$args     = wp_parse_args( $args, array( 'limit' => -1 ) );
		$products = WCCS()->products->get_products( $args );
		if ( empty( $products ) ) {
			return array();
		}

		return $this->prepare_product_select( $products );
	}

	public function get_variations( array $args = array() ) {
		$args     = wp_parse_args( $args, array( 'type' => 'variation', 'limit' => -1 ) );
		$products = WCCS()->products->get_products( $args );
		if ( empty( $products ) ) {
			return array();
		}

		return $this->prepare_product_select( $products, true );
	}

	protected function prepare_product_select( array $products, $variation = false ) {
		$products_select = array();
		foreach ( $products as $product ) {
			if ( $product->get_sku() ) {
				$identifier = $product->get_sku();
			} else {
				$identifier = '#' . $product->get_id();
			}

			if ( $variation ) {
				$formatted_variation_list = wc_get_formatted_variation( $product, true );
				$text = sprintf( '%2$s (%1$s)', $identifier, $product->get_title() ) . ' ' . $formatted_variation_list;
			} else {
				$text = sprintf( '%2$s (%1$s)', $identifier, $product->get_title() );
			}

			$products_select[] = (object) array(
				'id'   => $product->get_id(),
				'text' => $text,
			);
		}

		return $products_select;
	}

}
