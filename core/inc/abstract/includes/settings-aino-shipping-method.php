<?php

if (!defined('ABSPATH')) {
    exit;
}
global $woocommerce;
$cost_desc = __('Enter a cost (excl. tax) or sum, e.g. <code>10.00 * [qty]</code>.', 'woocommerce') . '<br/><br/>' 
        . __('Use <code>[qty]</code> for the number of items, <br/><code>[cost]</code> for the total cost of items, and <code>[fee percent="10" min_fee="20" max_fee=""]</code> for percentage based fees.', 'woocommerce');

$rates_func = !empty($this->get_options()['deliveryDetails']['type']) 
        ? 'WC_VC_Table_rates_table_complex' 
        : 'WC_VC_Table_rates_table';

/**
 * Settings for flat rate shipping.
 */
$settings = array(
    'title' => array(
        'title' => __('Method Title', 'vc-allinone'),
        'type' => 'text',
        'description' => __('This controls the title which the user '
                . 'sees during checkout.', 'vc-allinone'),
        'default' => __($this->method_title, 'vc-allinone'),
        'desc_tip' => true,
    ),
    'tax_status' => array(
        'title' => __('Tax Status', 'woocommerce'),
        'type' => 'select',
        'class' => 'wc-enhanced-select',
        'default' => 'taxable',
        'options' => array(
            'taxable' => __('Taxable', 'woocommerce'),
            'none' => _x('None', 'Tax status', 'woocommerce')
        )
    ),
    'description' => array(
        'title' => __('Description', 'vc-allinone'),
        'type' => 'text',
        'description' => __('This is the delivery time the customer sees during checkout', 'vc-allinone'),
//        'default' => __($this->description, 'vc-allinone'),
        'desc_tip' => true,
    ),
    'description2' => array(
        'title' => __('Description 2', 'vc-allinone'),
        'type' => 'text',
        'description' => __('This is the option label', 'vc-allinone'),
//        'default' => __($this->description2, 'vc-allinone'),
        'desc_tip' => true,
    ),
    'vc_rates' => array(
        'title' => __('Rates', 'vc-allinone'),
        'type' => 'title'
    ),
    'rates' => array(
        'type' => $rates_func
    )
);

$shipping_classes = WC()->shipping->get_shipping_classes();

if (!empty($shipping_classes)) {
    $settings['class_costs'] = array(
        'title' => __('Shipping Class Costs', 'woocommerce'),
        'type' => 'title',
        'default' => '',
        'description' => sprintf(__('These costs can optionally be added based on the %sproduct shipping class%s.', 'woocommerce'), '<a href="' . admin_url('edit-tags.php?taxonomy=product_shipping_class&post_type=product') . '">', '</a>')
    );
    foreach ($shipping_classes as $shipping_class) {
        if (!isset($shipping_class->term_id)) {
            continue;
        }
        $settings['class_cost_' . $shipping_class->term_id] = array(
            'title' => sprintf(__('"%s" Shipping Class Cost', 'woocommerce'), esc_html($shipping_class->name)),
            'type' => 'text',
            'placeholder' => __('N/A', 'woocommerce'),
            'description' => $cost_desc,
            'default' => $this->get_option('class_cost_' . $shipping_class->slug), // Before 2.5.0, we used slug here which caused issues with long setting names
            'desc_tip' => true
        );
    }
    $settings['no_class_cost'] = array(
        'title' => __('No Shipping Class Cost', 'woocommerce'),
        'type' => 'text',
        'placeholder' => __('N/A', 'woocommerce'),
        'description' => $cost_desc,
        'default' => '',
        'desc_tip' => true
    );
    $settings['type'] = array(
        'title' => __('Calculation Type', 'woocommerce'),
        'type' => 'select',
        'class' => 'wc-enhanced-select',
        'default' => 'class',
        'options' => array(
            'class' => __('Per Class: Charge shipping for each shipping class individually', 'woocommerce'),
            'order' => __('Per Order: Charge shipping for the most expensive shipping class', 'woocommerce'),
        ),
    );
}

return $settings;
