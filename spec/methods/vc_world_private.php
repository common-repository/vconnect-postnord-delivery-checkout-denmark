<?php

if (!class_exists('WC_VC_World_Private')) {

    class WC_VC_World_Private extends Vc_Aino_Shipping_Method {

        // Id for your shipping method. Should be unique.
        public $vc_aino_id = 'vconnect_postnord_dk_dpdinternational';
        // Title shown in admin
        public $vc_aino_type = 'internationalDelivery';
        // Title shown in admin
        protected $vc_aino_method_title = 'International levering';
        // Description shown in admin
        protected $vc_aino_method_description = 'Description of your shipping method';
        // This can be added as an setting but for this example its forced.
        protected $vc_aino_title = 'International Delivery';

    }

}