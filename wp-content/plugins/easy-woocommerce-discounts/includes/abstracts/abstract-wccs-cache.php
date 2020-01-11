<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WCCS_Abstract_Cache {

    protected $cache_prefix;
    protected $cache_group;

    public function __construct( $cache_prefix, $cache_group ) {
        $this->cache_prefix = $cache_prefix;
        $this->cache_group  = $cache_group;
    }

    public function get_cache_prefix() {
        return $this->cache_prefix;
    }

    public function get_cache_group() {
        return $this->cache_group;
    }

    public function clear_cache() {
        WC_Cache_Helper::get_transient_version( $this->cache_group, true );
    }

    public function get_transient_version( $refresh = false ) {
        return WC_Cache_Helper::get_transient_version( $this->cache_group, $refresh );
    }

    public function get_transient_name( array $args = array() ) {
        if ( empty( $args ) ) {
            return false;
        }

        return $this->cache_prefix . md5( wp_json_encode( $args ) . WC_Cache_Helper::get_transient_version( $this->cache_group ) );
    }

}
