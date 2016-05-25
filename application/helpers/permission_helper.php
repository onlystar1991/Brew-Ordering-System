<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * PERMISSION CONTROL
 * 
 * Create a permission funcs.
 *
 * @access	public
 * @param   string
 * @return	string
 */
if (!function_exists('user_permissions_by_role')) {
    function user_permissions_by_role($role) {
        $permissions = array();

        switch ($role) {
            case UR_ADMIN:
            $permissions = array(UP_STORE_ALL, UP_INVENTORY_ALL, UP_ORDER_ALL, UP_DASHBOARD_ALL, UP_DISTRIBUTOR_ALL, UP_DELIVERY_ALL, UP_MARKETING_ALL, UP_ALL);
            break;
            case UR_RETAILER:
            $permissions = array(UP_STORE_ALL, UP_INVENTORY_ALL, UP_ORDER_ALL, UP_DISTRIBUTOR_ALL, UP_DELIVERY_ALL, UP_MARKETING_ALL);
            break;
            case UR_BAR:
            $permissions = array(UP_STORE_ALL, UP_INVENTORY_ALL, UP_DISTRIBUTOR_ALL, UP_MARKETING_ALL);
            break;
            case UR_BREWERY:
            $permissions = array(UP_STORE_ALL, UP_INVENTORY_ALL, UP_ORDER_ALL, UP_DISTRIBUTOR_ALL, UP_MARKETING_ALL);
            break;
            case UR_DISTRIBUTOR:
            default:
            $permissions = array(UP_INVENTORY_VIEW, UP_INVENTORY_ORDER_DENY, UP_ORDER_EDIT_DENY, UP_ORDER_VIEW, UP_ORDER_DETAIL_DENY);
        }

        return $permissions;
    }

    function user_can($privilege) {

        // get the superobject
        $CI =& get_instance();

        $cu_permissions = $CI->session->userdata('role');

        // echo "<script>alert('".print_r($cu_permissions)."')</script>";

        if (in_array($privilege, $cu_permissions))
            return true;
        else
            return false;
    }

    function is_user($role) {
        // get the superobject
        $CI =& get_instance();

        $cu_role = $CI->session->userdata('permission');

        if ($cu_role == $role)
            return true;
        else
            return false;   
    }
}

/* End of file permission_helper.php */
/* Location: ./application/helpers/permission_helper.php */