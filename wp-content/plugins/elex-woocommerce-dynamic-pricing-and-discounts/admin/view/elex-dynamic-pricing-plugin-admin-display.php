<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (isset($_REQUEST['tab'])) {
    $active_tab = $_REQUEST['tab'];
} else {
    $active_tab = 'product_rules';
}
if(isset($_REQUEST['submit']))
{
    //check_admin_referer( 'save_rule_'.$_REQUEST['update'] );
    $path = elex_dp_root_path_basic . 'admin/data/settings_page/elex-save-options.php';
    if (file_exists($path) == true)
        include_once ( $path );    
}
if(isset($_REQUEST['cancel_btn']))
{
    wp_safe_redirect(admin_url('admin.php?page=dynamic-pricing-main-page&tab=' . $active_tab));
    die();
}

if (isset($_REQUEST['update']) && empty($_REQUEST['update'])) {    //Submit And Not Edit Then Saving New Record
    check_admin_referer( 'save_rule' );
    $current_tab_loc = (isset($_REQUEST['tab']) && !empty($_REQUEST['tab'])) ? sanitize_text_field($_REQUEST['tab']) . '/' : 'product_rules/';
    $path = elex_dp_root_path_basic . 'admin/data/' . $current_tab_loc . 'elex-save-options.php';
    if (file_exists($path) == true)
        include_once ( $path );
}
elseif (isset($_REQUEST['edit']) && !empty($_REQUEST['edit'])) {    //Loading Edit Form Or Updating Data
    $old_option = get_option('xa_dp_rules',array($active_tab=>array()));
    $old_option=  $old_option[$active_tab];
    $_REQUEST = array_merge($_REQUEST, $old_option[$_REQUEST['edit']]);
    $current_tab_loc = isset($_REQUEST['tab']) && !empty($_REQUEST['tab']) ? sanitize_text_field($_REQUEST['tab']) . '/' : 'product_rules/';
    $path = elex_dp_root_path_basic . 'admin/data/' . $current_tab_loc . 'elex-load-edit.php';
    include_once ( $path );
} elseif ( !empty($_REQUEST['update'])) {
    check_admin_referer('update_rule_'.$_REQUEST['update'] );
    $path = isset($_REQUEST['tab']) && !empty($_REQUEST['tab']) ? sanitize_text_field($_REQUEST['tab']) . '/' : 'product_rules/';
    $path = elex_dp_root_path_basic . 'admin/data/' . $path . 'elex-update-options.php';
    include_once ( $path );
} else {
    $active_tab = 'product_rules';
}

require('tabs/elex-tabs-html-render.php');
