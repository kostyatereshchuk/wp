<?php
/**
 * Plugin Name: ISRAEL IT Multi-Currency
 * Description: Provides a custom functionality for currency.
 * Version: 1.0
 * Author: ISRAEL IT
 * Author URI: https://www.israelitcenter.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: israelit-multi-currency
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// cURL function to get content
function israelit_multi_currency_get_web_page($url)
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS => 10,     // stop after 10 redirects
        CURLOPT_ENCODING => "",     // handle compressed
        CURLOPT_USERAGENT => "test", // name of client
        CURLOPT_AUTOREFERER => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT => 120,    // time-out on response
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $content = curl_exec($ch);

    curl_close($ch);

    return $content;
}

// get currency rates and save to custom ACF fields
function israelit_multi_currency_update_currencies()
{

    $url = 'https://api.exchangeratesapi.io/latest?base=ILS';

    $response = israelit_multi_currency_get_web_page($url);
    if (empty($response)) return false;

    $resArr = json_decode($response);

    if (empty((array)$resArr)) return false;

    $rates = array();
    $rates['usd'] = $resArr->rates->USD;
    #$rates['rub'] = $resArr->rates->RUB;

    foreach ($rates as $key => $value) {
        if ($value) update_field('currency_' . $key, $value, 'options');
    }

    update_field('currency_date', date('d.m.Y', strtotime(current_time('mysql'))), 'options');

}

// add "readonly" option to ACF text field for USD and RUB fields
add_action('acf/render_field_settings/type=text', 'add_readonly_and_disabled_to_text_field');
function add_readonly_and_disabled_to_text_field($field)
{
    acf_render_field_setting($field, array(
        'label' => __('Read Only?', 'acf'),
        'instructions' => '',
        'type' => 'radio',
        'name' => 'readonly',
        'choices' => array(
            0 => __("No", 'acf'),
            1 => __("Yes", 'acf'),
        ),
        'layout' => 'horizontal',
    ));
    acf_render_field_setting($field, array(
        'label' => __('Disabled?', 'acf'),
        'instructions' => '',
        'type' => 'radio',
        'name' => 'disabled',
        'choices' => array(
            0 => __("No", 'acf'),
            1 => __("Yes", 'acf'),
        ),
        'layout' => 'horizontal',
    ));
}

// detecting customer country
function israelit_multi_currency_get_customer_country()
{
    if ( ! class_exists( 'WC_Geolocation' ) ) {
        return false;
    }

    $location = WC_Geolocation::geolocate_ip();
    if (empty($location)) return false;
    return $location['country'];
}

// set user's currency depend on country (Russia-RUB, Israel-ILS, Other-USD)
function israelit_multi_currency_set_customer_currency()
{
    $default = 'USD';
    $country = israelit_multi_currency_get_customer_country();
    if (empty($country)) return $default;
    switch ($country) {
        /*
        case 'RU':
          $currency = 'RUB';
          break;
        */
        case 'IL':
            $currency = 'ILS';
            break;

        default:
            $currency = $default;
            break;
    }
    wc_setcookie('customer_currency', $currency, time() + 7 * 24 * 60 * 60);

    return $currency;
}

// get user's current currency
function israelit_multi_currency_get_customer_currency()
{
    $default = 'USD';
    $currency = isset($_COOKIE['customer_currency']) ? sanitize_text_field($_COOKIE['customer_currency']) : $default;
    if (empty($currency)) $currency = $default;

    return $currency;
}

function israelit_multi_currency_get_customer_currency_rate()
{
    $currency = israelit_multi_currency_get_customer_currency();
    if ($currency != 'ILS') {
        $rate = get_field('currency_' . strtolower($currency), 'options');
        if ($rate) return $rate;
    }
    return 1;
}


function israelit_multi_currency_currency_price($price, $product)
{
    return $price * israelit_multi_currency_get_customer_currency_rate();
}

function israelit_multi_currency_currency_price_sale($price, $product)
{
    $item = $product->get_data();
    if ($item['sale_price']) return $price * israelit_multi_currency_get_customer_currency_rate();
}

function filter_woocommerce_currency_symbol($symbol)
{
    $currency = israelit_multi_currency_get_customer_currency();
    switch ($currency) {
        case 'ILS':
            $symbol = '₪';
            break;
        /*
        case 'RUB':
          $symbol = '₽';
          break;
        */
        case 'USD':
            $symbol = '$';
            break;
        default:
            $symbol = '$';
            break;
    }
    return $symbol;
}

function filter_woocommerce_price_filter_widget_min_amount($post_price_0)
{
    return $post_price_0 * israelit_multi_currency_get_customer_currency_rate();
}

function filter_woocommerce_price_filter_widget_max_amount($post_price_1)
{
    return $post_price_1 * israelit_multi_currency_get_customer_currency_rate();
}

function israelit_multi_currency_switch_currency($currency)
{
    if (empty($currency)) return false;

    $currency = strtoupper($currency);
    if ($currency == israelit_multi_currency_get_customer_currency()) return $currency;

    if ($currency != 'USD' && $currency != 'ILS') return false;

    wc_setcookie('customer_currency', $currency, time() + 7 * 24 * 60 * 60);

    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
    wp_redirect($uri_parts[0]);
    exit();
}

if (!is_admin()) {

    if (isset($_GET['currency']) && !empty($_GET['currency'])) {
        israelit_multi_currency_switch_currency($_GET['currency']);
    }

    if (empty($_COOKIE['customer_currency'])) israelit_multi_currency_set_customer_currency();

    add_filter('woocommerce_product_get_price', 'israelit_multi_currency_currency_price', 10, 2);
    add_filter('woocommerce_product_variation_get_price', 'israelit_multi_currency_currency_price', 10, 2);
    add_filter('woocommerce_product_get_regular_price', 'israelit_multi_currency_currency_price', 10, 2);
    add_filter('woocommerce_product_get_sale_price', 'israelit_multi_currency_currency_price_sale', 10, 2);

    add_filter('woocommerce_currency_symbol', 'filter_woocommerce_currency_symbol', 10, 1);

    add_filter('woocommerce_price_filter_widget_min_amount', 'filter_woocommerce_price_filter_widget_min_amount', 99, 1);
    add_filter('woocommerce_price_filter_widget_max_amount', 'filter_woocommerce_price_filter_widget_max_amount', 99, 1);

    if (israelit_multi_currency_get_customer_currency() == 'USD') add_filter('woocommerce_currency', 'israelit_multi_currency_get_customer_currency', 100);
    if (israelit_multi_currency_get_customer_country() != 'IL') add_filter('woocommerce_cart_needs_shipping', '__return_false');


    if (isset($_GET['filters'])) {

        $filters_string = sanitize_text_field($_GET['filters']);
        $filters_parts = explode('|', $filters_string);

        $price_filter_string = '';

        foreach ($filters_parts as $filters_part) {
            if (strpos($filters_part, 'price') !== false) {
                $price_filter_string = $filters_part;

                break;
            }
        }

        if ($price_filter_string) {
            $price_range = str_replace('price[', '', $price_filter_string);
            $price_range = str_replace(']', '', $price_range);

            $price_range_parts = explode('_', $price_range);

            $min_price = $price_range_parts[0];
            $max_price = isset($price_range_parts[1]) ? $price_range_parts[1] : $min_price;
            $rate = israelit_multi_currency_get_customer_currency_rate();

            $new_min_price = $min_price / $rate; // TODO: Set the new min price
            $new_max_price = $max_price / $rate; // TODO: Set the new max price

            $new_price_filter_string = 'price[' . $new_min_price . '_' . $new_max_price . ']';

            $new_filters_string = str_replace($price_filter_string, $new_price_filter_string, $filters_string);

            $_GET['filters'] = $new_filters_string;
        }

    }

}


// setup cron to update currencies every 8 hours
add_filter('cron_schedules', 'israelit_multi_currency_every_eight_hours');
function israelit_multi_currency_every_eight_hours($schedules)
{
    $schedules['every_eight_hours'] = array(
        'interval' => 60 * 60 * 8,
        'display' => __('Every 8 hours', 'yp')
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if (!wp_next_scheduled('israelit_multi_currency_every_eight_hours')) {
    wp_schedule_event(time(), 'every_eight_hours', 'israelit_multi_currency_every_eight_hours');
}

add_action('israelit_multi_currency_every_eight_hours', 'israelit_multi_currency_every_eight_hours_function');
function israelit_multi_currency_every_eight_hours_function()
{
    israelit_multi_currency_update_currencies();
}

// currency switcher in header
function israelit_multi_currency_currency_switcher()
{
    $currency = israelit_multi_currency_get_customer_currency();
    if (empty($currency)) {
        $currency = 'USD';

        $country = israelit_multi_currency_get_customer_country();
        if ($country == 'IL') $currency = 'ILS';
    }

    $link = '';
    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
    if ($currency == 'USD') {
        $link = '<a href="' . $uri_parts[0] . '?currency=ILS">₪</a>';
    } elseif ($currency == 'ILS') {
        $link = '<a href="' . $uri_parts[0] . '?currency=USD">$</a>';
    }

    if (!is_checkout()) echo $link;
}