<?php

class Vc_Aino_Shipping_Methods {

    function __construct(){
        add_action('woocommerce_shipping_init', array($this, 'aio_shipping_methods_init'));
        add_filter('woocommerce_shipping_methods', array($this, 'add_aio_shipping_methods'));
    }

    function aio_shipping_methods_init() {
        // Require all shipping classes located in the classes/methods folder
        
        require_once AINO_PLUGIN_PATH . 'core/inc/abstract/vc_aino_shipping_method.php';
            
        foreach (glob(AINO_PLUGIN_PATH . '/spec/methods/*.php') as $filename){
            require_once $filename;
        }
    }

    /*
     * Add the shipping methods to WooCommerce
     */
    function add_aio_shipping_methods($methods) {
        $methods['vconnect_postnord_dk_privatehome']        = 'WC_VC_DK_Privatehome';
        $methods['vconnect_postnord_dk_pickup']             = 'WC_VC_DK_Pickup';
        $methods['vconnect_postnord_dk_commercial']         = 'WC_VC_DK_Commercial';
        $methods['vconnect_postnord_se_pickup']             = 'WC_VC_SE_Pickup';
        $methods['vconnect_postnord_no_pickup']             = 'WC_VC_NO_Pickup';
        $methods['vconnect_postnord_fi_pickup']             = 'WC_VC_FI_Pickup';
        $methods['vconnect_postnord_dk_dpdeu']              = 'WC_VC_EU_Private';
        $methods['vconnect_postnord_dk_dpdinternational']   = 'WC_VC_World_Private';

        return $methods;
    }    
}

new Vc_Aino_Shipping_Methods();