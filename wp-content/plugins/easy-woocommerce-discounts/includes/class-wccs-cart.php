<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCCS_Cart {

	public $cart;

	public function __construct( $cart = null ) {
		$this->cart = null !== $cart ? $cart : WC()->cart;
	}

	public function __get( $key ) {
		if ( property_exists( $this, $key ) ) {
			return $this->$key;
		} elseif ( is_null( $this->cart ) ) {
			return null;
		}

		return $this->cart->$key;
	}

	public function __call( $name, $arguments ) {
		if ( method_exists( $this, $name ) ) {
			return call_user_func_array( array( $this, $name ), $arguments );
		} elseif ( $this->cart && is_callable( array( $this->cart, $name ) ) ) {
			return call_user_func_array( array( $this->cart, $name ), $arguments );
		}
	}

	/**
	 * Return whether or not the cart is displaying prices including tax, rather than excluding tax.
	 *
	 * @since  2.2.4
	 *
	 * @return bool
	 */
	public function display_prices_including_tax() {
		if ( is_callable( array( $this->cart, 'display_prices_including_tax' ) ) ) {
			return $this->cart->display_prices_including_tax();
		}

		return apply_filters( 'woocommerce_cart_' . __FUNCTION__, 'incl' === $this->cart->tax_display_cart );
	}

	public function get_product_price( $product, $args = array() ) {
		if ( is_numeric( $product ) ) {
			$product = wc_get_product( $product );
		}

		if ( $this->display_prices_including_tax() ) {
			$product_price = wc_get_price_including_tax( $product, $args );
		} else {
			$product_price = wc_get_price_excluding_tax( $product, $args );
		}
		return apply_filters( 'woocommerce_cart_product_price', wc_price( $product_price ), $product );
	}

	public function get_products() {
		$cart_contents = $this->cart->get_cart();

		if ( empty( $cart_contents ) ) {
			return array();
		}

		$cart_products = array();

		foreach ( $cart_contents as $cart_item ) {
			if ( isset( $cart_item['product_id'] ) ) {
				$cart_products[] = $cart_item['product_id'];
			} elseif ( ! empty( $cart_item['data'] ) ) {
				$cart_products[] = $cart_item['data']->get_id();
			}
		}

		return $cart_products;
	}

	public function products_exists_in_cart( array $products, $type = 'at_least_one_of' ) {
		if ( empty( $products ) ) {
			return true;
		}

		if ( ! $this->cart ) {
			return false;
		}

		$cart_contents = $this->cart->get_cart();
		if ( empty( $cart_contents ) ) {
			return WCCS()->WCCS_Comparison->union_compare( $products, array(), $type );
		}

		foreach ( $products as $product ) {
			$found = false;
			foreach ( $cart_contents as $cart_item ) {
				if ( $product == $cart_item['product_id'] || ( ! empty( $cart_item['variation_id'] ) && $product == $cart_item['variation_id'] ) ) {
					$found = true;
					break;
				}
			}

			if ( $found ) {
				if ( 'at_least_one_of' === $type ) {
					return true;
				} elseif ( 'none_of' === $type ) {
					return false;
				}
			} elseif ( 'all_of' === $type || 'only' === $type ) {
				return false;
			}
		}

		if ( 'at_least_one_of' === $type ) {
			return false;
		} elseif ( 'none_of' === $type || 'all_of' === $type  ) {
			return true;
		} elseif ( 'only' === $type ) {
			foreach ( $cart_contents as $cart_item ) {
				if ( ! in_array( $cart_item['product_id'], $products ) && ( empty( $cart_item['variation_id' ] ) || ! in_array( $cart_item['variation_id'], $products ) ) ) {
					return false;
				}
			}

			return true;
		}

		return false;
	}

	public function categories_exists_in_cart( array $categories, $type = 'at_least_one_of' ) {
		if ( empty( $categories ) ) {
			return true;
		}

		if ( ! $this->cart ) {
			return false;
		}

		$cart_contents = $this->cart->get_cart();
		if ( empty( $cart_contents ) ) {
			return WCCS()->WCCS_Comparison->union_compare( $categories, array(), $type );
		}

		$cart_categories = array();

		foreach ( $cart_contents as $item => $item_data ) {
			$product_categories = wc_get_product_terms( $item_data['product_id'], 'product_cat', array( 'fields' => 'ids' ) );
			if ( 'at_least_one_of' === $type || 'none_of' === $type ) {
				if ( count( array_intersect( $categories, $product_categories ) ) ) {
					return 'at_least_one_of' === $type;
				}
			} else {
				$cart_categories = array_merge( $cart_categories, $product_categories );
			}
		}

		if ( 'at_least_one_of' === $type ) {
			return false;
		} elseif ( 'none_of' === $type ) {
			return true;
		}

		if ( ! empty( $cart_categories ) ) {
			if ( 'all_of' === $type ) {
				return ! count( array_diff( $categories, $cart_categories ) );
			} elseif ( 'only' === $type ) {
				return ! count( array_diff( $categories, $cart_categories ) ) && ! count( array_diff( $cart_categories, $categories ) );
			}
		}

		return false;
	}

	/**
	 * Is given attributes terms exists in the cart.
	 *
	 * @since  2.0.0
	 *
	 * @param  array  $attributes_terms
	 * @param  string $type
	 *
	 * @return boolean
	 */
	public function attributes_terms_exists_in_cart( array $attributes_terms, $type = 'at_least_one_of' ) {
		if ( empty( $attributes_terms ) ) {
			return true;
		}

		if ( ! $this->cart ) {
			return false;
		}

		$cart_items = $this->cart->get_cart();
		if ( empty( $cart_items ) ) {
			return WCCS()->WCCS_Comparison->union_compare( $attributes_terms, array(), $type );
		}

		$terms = array();
		foreach ( $cart_items as $cart_item ) {
			if ( empty( $cart_item['variation_id'] ) || empty( $cart_item['variation'] ) ) {
				continue;
			}

			foreach ( $cart_item['variation'] as $key => $value ) {
				if ( 0 === strpos( $key, 'attribute_' ) ) {
					$term = get_term_by( 'slug', $value, str_replace( 'attribute_', '', $key ) );
					if ( ! is_wp_error( $term ) && is_object( $term ) && $term->term_id ) {
						$terms[] = $term->term_id;
					}
				}
			}
		}

		return WCCS()->WCCS_Comparison->union_compare( $attributes_terms, array_unique( $terms ), $type );
	}

	public function tags_exists_in_cart( array $tags, $type = 'at_least_one_of' ) {
		if ( empty( $tags ) ) {
			return true;
		}

		if ( ! $this->cart ) {
			return false;
		}

		$cart_contents = $this->cart->get_cart();
		if ( empty( $cart_contents ) ) {
			return WCCS()->WCCS_Comparison->union_compare( $tags, array(), $type );
		}

		$product_helpers = WCCS()->product_helpers;

		$cart_tags = array();

		foreach ( $cart_contents as $item => $item_data ) {
			$product_tags = $product_helpers->wc_get_product_term_ids( $item_data['product_id'], 'product_tag' );
			if ( 'at_least_one_of' === $type || 'none_of' === $type ) {
				if ( count( array_intersect( $tags, $product_tags ) ) ) {
					return 'at_least_one_of' === $type;
				}
			} else {
				$cart_tags = array_merge( $cart_tags, $product_tags );
			}
		}

		if ( 'at_least_one_of' === $type ) {
			return false;
		} elseif ( 'none_of' === $type ) {
			return true;
		}

		if ( ! empty( $cart_tags ) ) {
			if ( 'all_of' === $type ) {
				return ! count( array_diff( $tags, $cart_tags ) );
			} elseif ( 'only' === $type ) {
				return ! count( array_diff( $tags, $cart_tags ) ) && ! count( array_diff( $cart_tags, $tags ) );
			}
		}

		return false;
	}

	public function get_items_quantities( array $items, $quantity_based_on = 'single_product', $exclude_excluded_products = false ) {
		if ( empty( $items ) ) {
			return array();
		}

		$cart_items = $this->filter_cart_items( $items, $exclude_excluded_products );
		if ( empty( $cart_items ) ) {
			return array();
		}

		return $this->get_cart_quantities_based_on( $quantity_based_on, $cart_items );
	}

	/**
	 * Get items subtotal.
	 *
	 * @since  2.5.0
	 *
	 * @param  array   $items
	 * @param  boolean $include_tax
	 * @param  boolean $exclude_excluded_products
	 *
	 * @return float
	 */
	public function get_items_subtotal( array $items, $include_tax = true, $exclude_excluded_products = false ) {
		if ( empty( $items ) ) {
			return 0;
		}

		$cart_items = $this->filter_cart_items( $items, $exclude_excluded_products );
		if ( empty( $cart_items ) ) {
			return 0;
		}

		$subtotal = 0;
		foreach ( $cart_items as $cart_item ) {
			$subtotal += $include_tax ? $cart_item['line_subtotal'] + $cart_item['line_subtotal_tax'] : $cart_item['line_subtotal'];
		}

		return apply_filters( 'wccs_cart_get_items_subtotal', (float) $subtotal, $items, $include_tax, $exclude_excluded_products );
	}

	public function filter_cart_items( array $items, $exclude_excluded_products = false ) {
		if ( ! $this->cart || empty( $items ) ) {
			return array();
		}

		$cart_contents = $this->cart->get_cart();
		if ( empty( $cart_contents ) ) {
			return array();
		}

		$cart_items = array();
		foreach ( $cart_contents as $cart_item_key => $cart_item ) {
			if ( WCCS()->WCCS_Product_Validator->is_valid_product( $items, (int) $cart_item['product_id'], (int) $cart_item['variation_id'], ( ! empty( $cart_item['variation'] ) ? $cart_item['variation'] : array() ) ) ) {
				if ( ! $exclude_excluded_products || ! WCCS()->pricing->is_in_exclude_rules( $cart_item['product_id'], $cart_item['variation_id'], ( ! empty( $cart_item['variation'] ) ? $cart_item['variation'] : array() ) ) ) {
					$cart_items[ $cart_item_key ] = $cart_item;
				}
			}
		}

		return $cart_items;
	}

	/**
	 * Getting products quantities in the cart.
	 *
	 * @since  1.0.0
	 *
	 * @param  $include                   array   An array of included items. product ids or array( 'all_products' ) or array( 'all_categories' ) to getting all cart items quantities.
	 * @param  $exclude                   array   An array of excluded items. product ids
	 * @param  $quantity_based_on         string
	 * @param  $exclude_excluded_products boolean Exclude products that are excluded by pricing exclude rules.
	 *
	 * @return array
	 */
	public function get_products_quantities( array $include, array $exclude = array(), $quantity_based_on = 'single_product', $exclude_excluded_products = false ) {
		if ( empty( $include ) && empty( $exclude ) ) {
			return array();
		}

		$cart_items = $this->filter_cart_products( $include, $exclude, $exclude_excluded_products );
		if ( empty( $cart_items ) ) {
			return array();
		}

		return $this->get_cart_quantities_based_on( $quantity_based_on, $cart_items );
	}

	/**
	 * Filtering cart items based on given products.
	 *
	 * @since  1.0.0
	 *
	 * @param  $include                   array   An array of included items. product ids or array( 'all_products' ) or array( 'all_categories' ) to getting all cart items quantities.
	 * @param  $exclude                   array   An array of excluded items. product ids
	 * @param  $exclude_excluded_products boolean Exclude products that are excluded by pricing exclude rules.
	 *
	 * @return array
	 */
	public function filter_cart_products( array $include, array $exclude = array(), $exclude_excluded_products = false ) {
		if ( empty( $include ) && empty( $exclude ) ) {
			return array();
		} elseif ( ! $this->cart ) {
			return array();
		}

		$cart_contents = $this->cart->get_cart();
		if ( empty( $cart_contents ) ) {
			return array();
		}

		$pricing          = WCCS()->pricing;
		$valid_cart_items = array();

		if ( array( 'all_products' ) === $include || array( 'all_categories' ) === $include ) {
			if ( ! $exclude_excluded_products && empty( $exclude ) ) {
				return $cart_contents;
			}
		}

		foreach ( $cart_contents as $cart_item_key => $cart_item ) {
			if ( ! empty( $include ) ) {
				if ( isset( $cart_item['product_id'] ) && ! isset( $valid_cart_items[ $cart_item_key ] ) ) {
					if ( array( 'all_products' ) === $include || array( 'all_categories' ) === $include || in_array( $cart_item['product_id'], $include ) ) {
						if ( $exclude_excluded_products && ! $pricing->is_in_exclude_rules( $cart_item['product_id'], $cart_item['variation_id'], ( ! empty( $cart_item['variation'] ) ? $cart_item['variation'] : array() ) ) ) {
							if ( empty( $exclude ) ) {
								$valid_cart_items[ $cart_item_key ] = $cart_item;
							} elseif ( ! in_array( $cart_item['product_id'], $exclude ) && ( empty( $cart_item['variation_id'] ) || ! in_array( $cart_item['variation_id'], $exclude ) ) ) {
								$valid_cart_items[ $cart_item_key ] = $cart_item;
							}
						} elseif ( ! $exclude_excluded_products ) {
							if ( empty( $exclude ) ) {
								$valid_cart_items[ $cart_item_key ] = $cart_item;
							} elseif ( ! in_array( $cart_item['product_id'], $exclude ) && ( empty( $cart_item['variation_id'] ) || ! in_array( $cart_item['variation_id'], $exclude ) ) ) {
								$valid_cart_items[ $cart_item_key ] = $cart_item;
							}
						}
					}
				}

				if ( ! empty( $cart_item['variation_id'] ) && ! isset( $valid_cart_items[ $cart_item_key ] ) ) {
					if ( array( 'all_products' ) === $include || array( 'all_categories' ) === $include || in_array( $cart_item['variation_id'], $include ) ) {
						if ( $exclude_excluded_products && ! $pricing->is_in_exclude_rules( $cart_item['product_id'], $cart_item['variation_id'], ( ! empty( $cart_item['variation'] ) ? $cart_item['variation'] : array() ) ) ) {
							if ( empty( $exclude ) ) {
								$valid_cart_items[ $cart_item_key ] = $cart_item;
							} elseif ( ! in_array( $cart_item['product_id'], $exclude ) && ( empty( $cart_item['variation_id'] ) || ! in_array( $cart_item['variation_id'], $exclude ) ) ) {
								$valid_cart_items[ $cart_item_key ] = $cart_item;
							}
						} elseif ( ! $exclude_excluded_products ) {
							if ( empty( $exclude ) ) {
								$valid_cart_items[ $cart_item_key ] = $cart_item;
							} elseif ( ! in_array( $cart_item['product_id'], $exclude ) && ( empty( $cart_item['variation_id'] ) || ! in_array( $cart_item['variation_id'], $exclude ) ) ) {
								$valid_cart_items[ $cart_item_key ] = $cart_item;
							}
						}
					}
				}
			} elseif ( ! empty( $exclude ) ) {
				if ( ! in_array( $cart_item['product_id'], $exclude ) && ( empty( $cart_item['variation_id'] ) || ! in_array( $cart_item['variation_id'], $exclude ) ) ) {
					if ( $exclude_excluded_products && ! $pricing->is_in_exclude_rules( $cart_item['product_id'], $cart_item['variation_id'], ( ! empty( $cart_item['variation'] ) ? $cart_item['variation'] : array() ) ) ) {
						$valid_cart_items[ $cart_item_key ] = $cart_item;
					} elseif ( ! $exclude_excluded_products ) {
						$valid_cart_items[ $cart_item_key ] = $cart_item;
					}
				}
			}
		}

		return $valid_cart_items;
	}

	/**
	 * Getting cart items quantities based on given type.
	 *
	 * @since  2.0.0
	 *
	 * @param  string     $quantity_based_on
	 * @param  array|null $cart_items        When it is null it use default cart items.
	 *
	 * @return array
	 */
	public function get_cart_quantities_based_on( $quantity_based_on = 'single_product', array $cart_items = null ) {
		if ( empty( $quantity_based_on ) ) {
			return array();
		} elseif ( ! $this->cart ) {
			return array();
		}

		$cart_items = null !== $cart_items ? $cart_items : $this->cart->get_cart();
		if ( empty( $cart_items ) ) {
			return array();
		}

		$cart_quantities = array();

		switch ( $quantity_based_on ) {
			case 'single_product' :
				foreach ( $cart_items as $cart_item_key => $cart_item ) {
					if ( ! isset( $cart_quantities[ $cart_item['product_id'] ] ) ) {
						$cart_quantities[ $cart_item['product_id'] ] = array(
							'count' => 0,
							'items' => array(),
						);
					}

					$cart_quantities[ $cart_item['product_id'] ]['count'] += $cart_item['quantity'];
					$cart_quantities[ $cart_item['product_id'] ]['items'][ $cart_item_key ] = $cart_item['quantity'];
				}
				break;

			default :
				break;
		}

		return $cart_quantities;
	}

}
