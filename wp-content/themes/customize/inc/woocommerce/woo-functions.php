<?php if( ! defined( 'ABSPATH' ) ) exit;

function woocommerce_pagination() { ?>

			<div class="nextpage">
			
				<div class="pagination">
				
					<?php echo paginate_links(); ?>
					
				</div> 
				
			</div>   

  <?php  }
  
  
 /**
 * Add Cart icon and count to header if WC is active
 */
function my_wc_cart_count() {
 
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		global $woocommerce;
		$total = $woocommerce->cart->get_cart_total();
        $count = WC()->cart->cart_contents_count;
        ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>"><?php
        
		if ( $count == 0 ) {
			?>
			<span class="cart-contents-count"> Emty Cart</span> <i class="fa fa-cart-arrow-down"></i>
			<?php            
		}		
		if ( $count == 1 ) {
            ?>
            <span class="cart-contents-count"><?php echo esc_html( $count ); ?> Item</span> <i class="fa fa-cart-arrow-down"></i> <?php echo $total; ?>
            <?php
        }
        if ( $count > 1 ) {
            ?>
            <span class="cart-contents-count"><?php echo esc_html( $count ); ?> Items</span> <i class="fa fa-cart-arrow-down"></i> <?php echo $total; ?>
            <?php
        }		
		
                ?></a><?php
    }
 
}
add_action( 'your_theme_header_top', 'my_wc_cart_count' );

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
    ob_start();
		global $woocommerce;	
		$total = $woocommerce->cart->get_cart_total();
		$count = WC()->cart->cart_contents_count;
		?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>"><?php

			if ( $count == 0 ) {
				?>
				<span class="cart-contents-count"> Emty Cart</span> <i class="fa fa-cart-arrow-down"></i>
				<?php            
			}
			
			if ( $count == 1 ) {
				?>
				<span class="cart-contents-count"><?php echo esc_html( $count ); ?> Item</span> <i class="fa fa-cart-arrow-down"></i> <?php echo $total; ?>
				<?php            
			}
			if ( $count > 1 ) {
				?>
				<span class="cart-contents-count"><?php echo esc_html( $count ); ?> Items</span> <i class="fa fa-cart-arrow-down"></i> <?php echo $total; ?>
				<?php
			}			
			?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );


/**************************************
 Woo Cart Blinker
**************************************/

function customize_cart_blinker (){
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		if(get_theme_mod('customize_activate_blinker')) {
			global $woocommerce;	
			$count = WC()->cart->cart_contents_count;
			if ($count != 0) { ?>
				<style>.cart-contents { animation: blinker 2s linear infinite; } @keyframes blinker { 50% {opacity: 0.3;}</style>
				<?php
				}
			}
	}
}
add_action('wp_head','customize_cart_blinker');


/**************************************
 If is WooCommerce page
**************************************/

function customize_woocommerce_page () {
        if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
                return true;
        }
        $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                        "woocommerce_terms_page_id" ,
                                        "woocommerce_cart_page_id" ,
                                        "woocommerce_checkout_page_id" ,
                                        "woocommerce_pay_page_id" ,
                                        "woocommerce_thanks_page_id" ,
                                        "woocommerce_myaccount_page_id" ,
                                        "woocommerce_edit_address_page_id" ,
                                        "woocommerce_view_order_page_id" ,
                                        "woocommerce_change_password_page_id" ,
                                        "woocommerce_logout_page_id" ,
                                        "woocommerce_lost_password_page_id" ) ;
        foreach ( $woocommerce_keys as $wc_page_id ) {
                if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                        return true ;
                }
        }
        return false;
}