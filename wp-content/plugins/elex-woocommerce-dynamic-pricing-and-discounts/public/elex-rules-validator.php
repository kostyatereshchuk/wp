<?php

/**
 * This Class Handles Rules Filtering
 *
 * @author Akshay
 */
class Elex_dp_RulesValidator {

    Public $execution_mode = "first_match";
    Public $execution_order = array('product_rules', 'combinational_rules', 'cat_combinational_rules', 'category_rules', 'cart_rules', 'buy_get_free_rules','BOGO_category_rules');
    Public $rule_based_quantity = array();
    Public $for_offers_table = false;

    /**
     * Finds valid rules for a Product
     *
     * @param wc_product $product (object of product for which we need discounted price)
     * @param integer $pid (id of product)
     * 
     * @return array $valid_rules
     */
    function __construct($mode = '', $for_offers_table = false, $only_execute_this_mode = '') {
        global $xa_dp_setting;

        $this->for_offers_table = $for_offers_table;
        $this->execution_mode = empty($mode) ? $xa_dp_setting['mode'] : $mode;
        $this->execution_order = empty($only_execute_this_mode) ? (isset($xa_dp_setting['execution_order']) ? $xa_dp_setting['execution_order'] : array('product_rules',
            'combinational_rules',
            'cat_combinational_rules',
            'category_rules',
            'cart_rules',
            'buy_and_get_free_rules','BOGO_category_rules') ) : array($only_execute_this_mode);
    }
    /**
     * Function which converts product and category id's based on current language selected by user
     */

    Public Function elex_dp_getValidRulesForProduct($product, $pid = null, $current_quantity = 1, $price = 0, $weight = 0) {
        if (empty($pid))
            $pid = elex_dp_get_pid($product);
        if (!empty($pid)) {            
            switch ($this->execution_mode) {
                case "first_match":
                    return $this->elex_dp_getFirstMatchedRule($product, $pid, $current_quantity, $price, $weight);
                case "best_discount":
                    return $this->elex_dp_getBestMatchedRules($product, $pid, $current_quantity, $price, $weight);
                case "all_match":
                    return $this->elex_dp_getAllMatchedRules($product, $pid, $current_quantity, $price, $weight);
                default:
                    return false;
            }
        }
        return false;
    }

    Function elex_dp_getFirstMatchedRule($product, $pid, $current_quantity = 1, $price = 0, $weight = 0) {
        global $xa_dp_rules;
        foreach ($this->execution_order as $rule_type) {
            $rules = !empty($xa_dp_rules[$rule_type])?$xa_dp_rules[$rule_type]:array();
            foreach ($rules as $rule_no => $rule) {
                //error_log($rule_type.'->'.$rule_no." pid=".$pid);
                $rule['rule_no'] = $rule_no;
                $rule['rule_type'] = $rule_type;
                if ($this->elex_dp_checkRuleApplicableForProduct($rule, $rule_type, $product, $pid, $current_quantity, $price, $weight) === true) {
                    //error_log('type='.$rule_type.' ruleno='.$rule_no.' pid='.$pid);
                    return array($rule_type . ":" . $rule_no => $rule);
                }
            }
        }
        return array();
    }

    Function elex_dp_getAllMatchedRules($product, $pid, $current_quantity = 1, $price = 0, $weight = 0) {
        global $xa_dp_rules;        
        $valid_rules = array();
        foreach ($this->execution_order as $rule_type) {
            $rules = !empty($xa_dp_rules[$rule_type])?$xa_dp_rules[$rule_type]:array();
            if (!empty($rules)) {

                foreach ($rules as $rule_no => $rule) {
                    //error_log($rule_type.'->'.$rule_no." pid=".$pid);
                    $rule['rule_no'] = $rule_no;
                    $rule['rule_type'] = $rule_type;
                    if ($this->elex_dp_checkRuleApplicableForProduct($rule, $rule_type, $product, $pid, $current_quantity, $price, $weight) === true) {
                        //error_log('type='.$rule_type.' ruleno='.$rule_no.' pid='.$pid);
                        $valid_rules[$rule_type . ":" . $rule_no] = $rule;
                    }
                }
            }
        }
        return $valid_rules;
    }

    Function elex_dp_getBestMatchedRules($product, $pid, $current_quantity = 1, $price = 0, $weight = 0) {
        global $xa_dp_rules;
        $valid_rules = array();
        $max_price = 9999999;
        foreach ($this->execution_order as $rule_type) {
            $rules = !empty($xa_dp_rules[$rule_type])?$xa_dp_rules[$rule_type]:array();
            if (!empty($rules)) {
                foreach ($rules as $rule_no => $rule) {
                    //error_log($rule_type.'->'.$rule_no." pid=".$pid);
                    $rule['rule_no'] = $rule_no;
                    $rule['rule_type'] = $rule_type;
                    if ($this->elex_dp_checkRuleApplicableForProduct($rule, $rule_type, $product, $pid, $current_quantity, $price, $weight) === true) {
                        
                        if (!empty($rule['calculated_discount']) && $max_price > $rule['calculated_discount']) {   //error_log('type='.$rule_type.' ruleno='.$rule_no.' pid='.$pid);
                            $max_price = $rule['calculated_discount'];
                            $valid_rules = array($rule_type . ":" . $rule_no => $rule);                            
                        }
                    }
                }
            }
        }
        return $valid_rules;
    }

    Public Function elex_dp_checkRuleApplicableForProduct(&$rule = null, $rule_type = '', $product = null, $pid = null, $current_quantity = 1, $price = 0, $weight = 0) {
        if( apply_filters('eha_dp_skip_product',false,$pid,$rule,$rule_type)!=false){     
            return false;
        }
        if (!empty($rule) && !empty($rule_type) && !empty($pid)) {
            switch ($rule_type) {
                case 'product_rules':
                    $valid = $this->elex_dp_checkProductRuleApplicableForProduct($rule, $product, $pid, $current_quantity, $price, $weight);
                    break;
                case 'category_rules':
                    $valid = $this->elex_dp_checkCategoryRuleApplicableForProduct($rule, $product, $pid, $current_quantity, $price, $weight);
                    break;
               
            }
            global $customer;
            if (!empty($rule['prev_order_count']) || !empty($rule['prev_order_total_amt'])) {
                $order_count = elex_dp_is_wc_version_gt_eql('2.7') ? $customer->get_order_count() : wc_get_customer_order_count($customer->id);
                $total_spent = elex_dp_is_wc_version_gt_eql('2.7') ? $customer->get_total_spent() : wc_get_customer_total_spent($customer->id);
                //error_log('order_count='.$order_count." total spent=".$total_spent);
                if (!empty($rule['prev_order_count']) && (int) $rule['prev_order_count'] > $order_count) {
                    return false;
                }
                if (!empty($rule['prev_order_total_amt']) && (float) $rule['prev_order_total_amt'] > $total_spent) {
                    return false;
                }
            }
            global $current_user;
            if (!empty($rule['email_ids'])) {
                $customer_email = $current_user->user_email;
                $emails = explode(',', $rule['email_ids']);
                if (empty($customer_email) || !in_array($customer_email, $emails)) {
                        return false;
                    }
            }
            return $valid;
        }
        return false;
    }

    Function elex_dp_checkCategoryRuleApplicableForProduct(&$rule = null, $product = null, $pid = null, $current_quantity = 1, $price = 0, $weight = 0) {
//        echo "<pre>";
//        print_r($rule);
//        echo "</pre>";       
        global $xa_cart_quantities;
        global $xa_cart_weight;
        global $xa_cart_price;
        global $xa_cart_categories;
        $min = (empty($rule['min']) == true) ? 1 : $rule['min'];
        $max = (empty($rule['max']) == true ) ? 999999 : $rule['max'];

        if ($max < $min && $max != 0) {
            return false;
        }  
        //if pid is selected in this rule
        
        $cids=array();
        $cat_ids=$rule['category_id'];
        if(!is_array($cat_ids)) $cat_ids=array($cat_ids);
        foreach( $cat_ids as $_cid)
        {
            $cids[] = elex_dp_WPML_Compatible_ids($_cid,'category');
        }       
        $tmp=elex_dp_get_category_ids($pid);
        $product_categories=!empty($tmp)?$tmp:array();
        $matched=array_intersect($cids, $product_categories);
        if (empty($cids) || empty($matched)) {
            return false;
        }
        $rule['selected_cids']=$matched;
        if ($this->for_offers_table == true) {
            return $this->elex_dp_check_date_range_and_roles($rule, 'category_rules');
        } // to show in offers table        
        
        $total_items_of_this_category_in_cart = 0;
        $total_all_units_of_this_category_in_cart = 0;
        $total_weight_of_this_category = 0;
        $total_price_of_this_category = 0;
        if (is_shop() || is_product_category() || is_product()) {
            $current_quantity++;
            if (empty($xa_cart_quantities[$pid])) {
                $total_items_of_this_category_in_cart++;
            }
            $total_all_units_of_this_category_in_cart++;
            $total_weight_of_this_category += !empty($xa_cart_weight[$pid]) ? $xa_cart_weight[$pid] : (float) $product->get_weight();
            $total_price_of_this_category += !empty($xa_cart_price[$pid]) ? $xa_cart_price[$pid] : (float) $price;
        }
        foreach ($xa_cart_categories as $_pid => $_categories) {
            $match=array_intersect($matched,$_categories);
            if (!empty($match)) {
                $total_items_of_this_category_in_cart++;
                $qnty=!empty($xa_cart_quantities[$_pid])?$xa_cart_quantities[$_pid]:1;
                if (!empty($xa_cart_quantities[$_pid])) {
                    $total_all_units_of_this_category_in_cart += (int) $qnty;
                }
                if (!empty($xa_cart_weight[$_pid])) {
                    $total_weight_of_this_category += (int) ( $qnty * $xa_cart_weight[$_pid]);
                }
                if (!empty($xa_cart_price[$_pid])) {
                    $total_price_of_this_category += (int) ( $qnty * $xa_cart_price[$_pid]);
                }
            }
        }
        if ($total_items_of_this_category_in_cart == 0) {
            $total_items_of_this_category_in_cart = 1;
            $total_all_units_of_this_category_in_cart = 1;
            $total_weight_of_this_category = (float) $product->get_weight();
            $total_price_of_this_category = $price;
        }
        $this->rule_based_quantity[$rule['rule_type'] . ":" . $rule['rule_no']] = $total_all_units_of_this_category_in_cart;   // for adjustment
        //error_log('total units=' . $total_all_units_of_this_category_in_cart . " total items=" . $total_items_of_this_category_in_cart);
        //error_log('total price=' . $total_price_of_this_category . " total weights=" . $total_weight_of_this_category);
        if ($rule['check_on'] == 'TotalQuantity' && ($total_all_units_of_this_category_in_cart < $min || $total_all_units_of_this_category_in_cart > $max || empty($total_all_units_of_this_category_in_cart))) {
            return false;
        } elseif ($rule['check_on'] == 'Quantity' && ($total_items_of_this_category_in_cart < $min || $total_items_of_this_category_in_cart > $max || empty($total_items_of_this_category_in_cart))) {
            return false;
        } elseif ($rule['check_on'] == 'Weight' && ($total_weight_of_this_category < $min || $total_weight_of_this_category > $max || empty($total_weight_of_this_category))) {
            return false;
        } elseif ($rule['check_on'] == 'Price' && ($total_price_of_this_category < $min || $total_price_of_this_category > $max || empty($total_price_of_this_category))) {
            return false;
        }

        //to check best descount rule
        if ($this->execution_mode == "best_discount")
            $rule['calculated_discount'] = $this->elex_dp_SimpleExecute($price, $rule['rule_no'], $rule, $pid, $current_quantity, true);

        //checking roles and tofrom date for which rule is applicable
        return $this->elex_dp_check_date_range_and_roles($rule, 'category_rules');
    }


    Function elex_dp_checkProductRuleApplicableForProduct(&$rule = null, $product = null, $pid = null, $current_quantity = 1, $price = 0, $weight = 0) {
        global $xa_cart_categories;

        if (empty($pid)) {
            $pid = elex_dp_get_pid($product);
        }
        $min = (empty($rule['min']) == true) ? 1 : $rule['min'];
        $max = (empty($rule['max']) == true ) ? 999999 : $rule['max'];
        $total_price = !empty($price) ? ($price * $current_quantity) : 0;
        $total_weight = !empty($weight) ? ($weight * $current_quantity) : 0;
        if ($max < $min && $max != 0) {
            return false;
        }
        $repeat = false;
        if (isset($rule['repeat_rule']) && $rule['repeat_rule'] == 'yes') {
            $repeat = true;
        }
        //if pid is selected in this rule
        if (!empty($product) && $product->is_type('variation')) {
            $check_for_pid = elex_dp_is_wc_version_gt_eql('2.7') ? $product->get_parent_id() : $product->parent->id;
        } else {
            $check_for_pid = $pid;
        }
        if ($rule['rule_on'] == 'products') {
            $pids = elex_dp_WPML_Compatible_ids($rule['product_id']);
            if (empty($pids) || (!is_array($pids) || (!in_array($check_for_pid, $pids) && !in_array($pid, $pids)))) {
                return false;
            }
        } elseif ($rule['rule_on'] == 'categories') {
            if ($product->is_type('variation')) {
                $parent_id=elex_dp_is_wc_version_gt_eql('2.7') ? $product->get_parent_id() : $product->parent->id;
                $parent_product = wc_get_product($parent_id);
                $product_categories = elex_dp_is_wc_version_gt_eql('2.7') ? $parent_product->get_category_ids() : elex_dp_get_category_ids($parent_product);                    
            } else {
                $product_categories = elex_dp_is_wc_version_gt_eql('2.7') ? $product->get_category_ids() : elex_dp_get_category_ids($product);
            }
            $cids=array();
            $cat_ids=$rule['category_id'];
            if(!is_array($cat_ids)) $cat_ids=array($cat_ids);
            foreach( $cat_ids as $_cid)
            {
                $cids[] = elex_dp_WPML_Compatible_ids($_cid,'category');
            }       
            $matched=array_intersect($cids, $product_categories);
            if (empty($cids) || empty($matched)) {
                return false;
            }
        } elseif ($rule['rule_on'] == 'cart') {
            global $xa_cart_quantities;
            if (empty($xa_cart_quantities) || !in_array($pid, array_keys($xa_cart_quantities))) {
                return false;
            }
        }
        if ($this->for_offers_table == true) {
            return $this->elex_dp_check_date_range_and_roles($rule, 'product_rules');
        } // to show in offers table        
        if ($rule['check_on'] == 'Quantity' && ($current_quantity < $min || ($current_quantity > $max && $repeat == false))) {
            return false;
        } elseif ($rule['check_on'] == 'Weight' && ($total_weight < $min || ($total_weight > $max && $repeat == false ) || empty($total_weight))) {
            return false;
        } elseif ($rule['check_on'] == 'Price' && ($total_price < $min || ( $total_price > $max && $repeat == false) || empty($total_price))) {
            return false;
        }
        $this->rule_based_quantity[$rule['rule_type'] . ":" . $rule['rule_no']] = $current_quantity;   // for adjustment
        //to check best descount rule
        if ($this->execution_mode == "best_discount")
            $rule['calculated_discount'] = $this->elex_dp_SimpleExecute($price, $rule['rule_no'], $rule, $pid, $current_quantity, true);
        //checking roles and tofrom date for which rule is applicable
        return $this->elex_dp_check_date_range_and_roles($rule, 'product_rules');
    }

    function elex_dp_check_date_range_and_roles($rule, $rule_type) {
        $fromdate = $rule['from_date'];
        $todate = $rule['to_date'];
        $user_roles = $rule['allow_roles'];
        if(!is_array($user_roles))
        {
            $user_roles=array($user_roles);
        }
        global $current_user;
        $match=array_intersect( (array)$user_roles, (array) $current_user->roles );
        if ( !in_array('all',$user_roles) && empty($match) && !empty($user_roles) ) {   
            return false;
        }        
        
        $now = date('d-m-Y');
        if ((empty($fromdate) && empty($todate)) || (empty($fromdate) && empty($todate) == false && (strtotime($now) <= strtotime($todate))) || (empty($fromdate) == false && (strtotime($now) >= strtotime($fromdate)) && empty($todate)) || ((strtotime($now) >= strtotime($fromdate)) && (strtotime($now) <= strtotime($todate)))) {
            
        } else {
            return false;
        }
        
        return true;
    }

    Public Function elex_dp_execute_rule($old_price, $rule_type_colon_rule_no, $rule, $current_quantity = 1, $pid = 0,$object_hash='') {
        global $executed_rule_pid_price,$executed_pids;
        $new_price = $old_price;
        $data = explode(':', $rule_type_colon_rule_no);
        $rule_type = $data[0];
        $rule_no = $data[1];
        if (isset($executed_rule_pid_price[$rule_type_colon_rule_no])  && !empty($object_hash)) {  // this code is using cache if already executed
            if (isset($executed_rule_pid_price[$rule_type_colon_rule_no][$object_hash])) {  
                    return $executed_rule_pid_price[$rule_type_colon_rule_no][$object_hash];
            }
        } else {
            $executed_rule_pid_price[$rule_type_colon_rule_no] = array();
        }
        
        switch ($rule_type) {
            case "product_rules":
                $new_price = $this->elex_dp_SimpleExecute($old_price, $rule_no, $rule, $pid,1,false,$object_hash);
                break;
            case "category_rules":
                $new_price = $this->elex_dp_Simple_Category_Execute($old_price, $rule_no, $rule, $pid,1,false,$object_hash);
                break;
           
        }
        if(empty($executed_pids[$pid]) || $executed_pids[$pid]>$new_price) $executed_pids[$pid]=$new_price;
        return $new_price;
    }

    Public Function elex_dp_SimpleExecute($old_price, $rule_no, $rule, $pid = 0, $current_quantity = 1, $do_not_execute = false,$object_hash='') {
        global $xa_common_flat_discount, $xa_cart_quantities, $executed_rule_pid_price,$xa_cart_categories_units,$xa_cart_categories,$xa_cart_price;
        $new_price = $old_price;
        $type_code = $rule['rule_type'] == 'product_rules'  ?  ($rule['rule_type'].$pid)   :  $rule['rule_type'];
        $cart_quantity = 0;
        $prev_total_discount=0;
        if($rule['rule_type'] == 'product_rules'){
            if(isset($rule['repeat_rule']) && $rule['repeat_rule'] == 'yes' && !empty($rule['max']) && !empty($rule['min'])){
                $cart_quantity=$current_quantity;
            }else
            {
                $cart_quantity = isset($xa_cart_quantities[$pid]) ?  $xa_cart_quantities[$pid] : 0;
            }
        }elseif($rule['rule_type'] == 'combinational_rules')
        {
            foreach($rule['product_id'] as $_id=>$qnty)
            {
                $avl_units = isset($xa_cart_quantities[$_id])?$xa_cart_quantities[$_id]:0;
                $cart_quantity+=$avl_units;                 
            }
        }elseif($rule['rule_type'] == 'cart_rules')
        {
            $cart_quantity = isset($xa_cart_quantities[$pid]) ?  $xa_cart_quantities[$pid] : 0;
            foreach($xa_cart_quantities as $ppid => $qnty){                
                if($ppid!==$pid ){
                    $rprice=isset($xa_cart_price[$ppid]) ?  $xa_cart_price[$ppid] : 0;
                    $sprice=isset($executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$ppid]) ?  $executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$ppid] : $rprice;
                    $prev_total_discount += ($rprice - $sprice ) * $qnty;
                }
            }
        }elseif($rule['rule_type'] == 'category_rules')
        {
            if(isset($rule['selected_cids'])) {
                $cid = current($rule['selected_cids']);
                $cart_quantity = isset($xa_cart_quantities[$pid]) ?  $xa_cart_quantities[$pid] : 0;
            }
            foreach($xa_cart_categories as $ppid => $cids){                
                $matched=array_intersect($cids,$rule['selected_cids']);
                if($ppid!==$pid && !empty($matched) && isset($xa_cart_quantities[$ppid]) ){
                    $units=isset($xa_cart_quantities[$ppid]) ?  $xa_cart_quantities[$ppid] : 0;
                    $rprice=isset($xa_cart_price[$ppid]) ?  $xa_cart_price[$ppid] : 0;
                    $sprice=isset($executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$ppid]) ?  $executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$ppid] : $rprice;
                    $prev_total_discount += ($rprice - $sprice ) * $units;
                }
            }
        }elseif($rule['rule_type'] == 'cat_combinational_rules')
        {   
            foreach($rule['cat_id'] as $cid=>$qnty)
            {
                $avl_units = isset($xa_cart_categories_units[$cid])?$xa_cart_categories_units[$cid]:0;
                $cart_quantity+=$avl_units;                
            }
        }else
        {
            $cart_quantity = isset($xa_cart_quantities[$pid]) ?  $xa_cart_quantities[$pid] : 0;
        }
        
        if (is_product() || is_shop() || is_product_category() || empty($cart_quantity)) {
            $cart_quantity++;
        }
        extract($rule);
        $discount_amt = 0;
        if ($discount_type == 'Percent Discount') { 
            $discount_amt = floatval($value) * floatval($old_price) / 100;
        } elseif ($discount_type == 'Flat Discount') {
            if ($do_not_execute === true) {
                $discount_amt = floatval($value);
            } else {
                $prev=!empty($xa_common_flat_discount[$rule['rule_type'] . ":" . $rule_no.":".$pid])?$xa_common_flat_discount[$rule['rule_type'] . ":" . $rule_no.":".$pid]:0;
                $xa_common_flat_discount[$rule['rule_type'] . ":" . $rule_no.":".$pid] =  floatval($prev) + floatval($value);
            }
        } elseif ($discount_type == 'Fixed Price') {
            $discount_amt = floatval($old_price) - floatval($value);
        } else {
            $discount_amt = 0;
        } 
        $total_units = 1;
        if (!empty($this->rule_based_quantity[$rule['rule_type'] . ":" . $rule['rule_no']]) && is_numeric($this->rule_based_quantity[$rule['rule_type'] . ":" . $rule['rule_no']])) {
            $total_units = !empty($this->rule_based_quantity[$rule['rule_type'] . ":" . $rule['rule_no']])?$this->rule_based_quantity[$rule['rule_type'] . ":" . $rule['rule_no']]:1;
        }
        
        if (!empty($max_discount) && is_numeric($max_discount) && ( ( ( $discount_amt * $cart_quantity  ) + $prev_total_discount  ) >= $max_discount )) {
            $discount_amt = ($max_discount - $prev_total_discount) / $cart_quantity;  
        }
        
        if (isset($adjustment) && is_numeric($adjustment)) {
            $units=!empty($cart_quantity)?$cart_quantity:$total_units;
            $discount_amt -= $adjustment / $units;
        }
        
        $new_price = $old_price - $discount_amt;
        if (isset($_GET['debug']) && $do_not_execute == false) {
            echo "\n<div id='rules_info' style=''><pre> RuleType= " . $rule['rule_type'] . " |   RuleNo=" . $rule_no . "  |   OldPrice=" . $old_price . "   |   Discount=$discount_amt  NewPrice=$new_price |   OfferName=" . $rule['offer_name'] . "</pre></div>";
        }
        //// code added to support discount on specified quantity in combinational rules only when it is restricted to discount on $pid
        if(!empty($rule['discount_on_product_id']) && in_array($pid,$rule['discount_on_product_id']) && !empty($rule['product_id'][$pid]) && !empty($xa_cart_quantities[$pid]) && $rule['product_id'][$pid]<$xa_cart_quantities[$pid])
        {
            $remaining_qnty=$xa_cart_quantities[$pid]-$rule['product_id'][$pid];
            $new_price=  (($new_price * $rule['product_id'][$pid])+ ($old_price * $remaining_qnty ))/$xa_cart_quantities[$pid];
        }
        ///// adding to cache
        if (!isset($executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$object_hash]) ) {
            $executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$object_hash] = $new_price;
        }
        if(!isset($executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$pid] ))
        {            
            $executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$pid] = $new_price;
        }
        return $new_price;
    }

    Public Function elex_dp_Simple_Category_Execute($old_price, $rule_no, $rule, $pid = 0, $current_quantity = 1, $do_not_execute = false,$object_hash='') {
        global $xa_common_flat_discount, $xa_cart_quantities, $executed_rule_pid_price,$xa_cart_categories_units,$xa_cart_categories,$xa_cart_price;
        $new_price = $old_price;
        $type_code = $rule['rule_type'] == 'product_rules'  ?  ($rule['rule_type'].$pid)   :  $rule['rule_type'];
        $cart_quantity = 0;
        $prev_total_discount=0;
        $total_units=0;
        if(isset($rule['selected_cids'])) {
            $cid = current($rule['selected_cids']);
            $cart_quantity = isset($xa_cart_quantities[$pid]) ?  $xa_cart_quantities[$pid] : 0;
        }
        foreach($xa_cart_categories as $ppid => $cids){                
            $matched=array_intersect($cids,$rule['selected_cids']);
            $units=isset($xa_cart_quantities[$ppid]) ?  $xa_cart_quantities[$ppid] : 0;
            $total_units+=$units;
            if($ppid!==$pid && !empty($matched) && isset($xa_cart_quantities[$ppid]) ){
                
                $rprice=isset($xa_cart_price[$ppid]) ?  $xa_cart_price[$ppid] : 0;
                $sprice=isset($executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$ppid]) ?  $executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$ppid] : $rprice;
                $prev_total_discount += ($rprice - $sprice ) * $units;
            }            
        }

        if (is_product() || is_shop() || is_product_category() || empty($cart_quantity)) {
            $cart_quantity++;
            $total_units++;
        }
        if($total_units==0) $total_units=1;
        extract($rule);
        $discount_amt = 0;
        if ($discount_type == 'Percent Discount') { 
            $discount_amt = floatval($value) * floatval($old_price) / 100;
        } elseif ($discount_type == 'Flat Discount') {
            if ($do_not_execute === true) {
                $discount_amt = floatval($value);
            } else {
                $prev=!empty($xa_common_flat_discount[$rule['rule_type'] . ":" . $rule_no.":".$pid])?$xa_common_flat_discount[$rule['rule_type'] . ":" . $rule_no.":".$pid]:0;
                $xa_common_flat_discount[$rule['rule_type'] . ":" . $rule_no.":".$pid] =  floatval($prev) + floatval($value);
            }
        } elseif ($discount_type == 'Fixed Price') {
            $discount_amt = floatval($old_price) - floatval($value);
        } else {
            $discount_amt = 0;
        } 

        if (!empty($max_discount) && is_numeric($max_discount) && ( ( ( $discount_amt * $cart_quantity  ) + $prev_total_discount  ) >= $max_discount )) {
            $discount_amt = ($max_discount - $prev_total_discount) / $cart_quantity;  
        }
        
        if (isset($adjustment) && is_numeric($adjustment)) {
            $discount_amt -= $adjustment / $cart_quantity;
        }
        
        $new_price = $old_price - $discount_amt;
        if (isset($_GET['debug']) && $do_not_execute == false) {
            echo "\n<div id='rules_info' style=''><pre> RuleType= " . $rule['rule_type'] . " |   RuleNo=" . $rule_no . "  |   OldPrice=" . $old_price . "   |   Discount=$discount_amt  NewPrice=$new_price |   OfferName=" . $rule['offer_name'] . "</pre></div>";
        }
        //// code added to support discount on specified quantity in combinational rules only when it is restricted to discount on $pid
        if(!empty($rule['discount_on_product_id']) && in_array($pid,$rule['discount_on_product_id']) && !empty($rule['product_id'][$pid]) && !empty($xa_cart_quantities[$pid]) && $rule['product_id'][$pid]<$xa_cart_quantities[$pid])
        {
            $remaining_qnty=$xa_cart_quantities[$pid]-$rule['product_id'][$pid];
            $new_price=  (($new_price * $rule['product_id'][$pid])+ ($old_price * $remaining_qnty ))/$xa_cart_quantities[$pid];
        }
        ///// adding to cache
        if (!isset($executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$object_hash]) ) {
            $executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$object_hash] = $new_price;
        }
        if(!isset($executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$pid] ))
        {            
            $executed_rule_pid_price[$rule['rule_type'] . ":" . $rule_no][$pid] = $new_price;
        }
        return $new_price;
    }

}
