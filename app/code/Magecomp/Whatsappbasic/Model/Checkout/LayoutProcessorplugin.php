<?php
namespace Magecomp\Whatsappbasic\Model\Checkout;

class LayoutProcessorplugin
{
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
    	array  $jsLayout
    ) {
    	$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
            ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['telephone']['notice'] = __('Enter Your WhatsApp Number.');
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['telephone']['config']['tooltip']['description'] = __('For Order Updates.');
    	return $jsLayout;
    }
}
