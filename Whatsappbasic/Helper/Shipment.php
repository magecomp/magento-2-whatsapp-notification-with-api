<?php 
namespace Magecomp\Whatsappbasic\Helper;

use Magento\Store\Model\ScopeInterface;

class Shipment extends \Magecomp\Whatsappbasic\Helper\Data
{
    // USER TEMPLATE
    const SMS_IS_CUSTOMER_SHIPMENT_NOTIFICATION = 'whatsappbasic/shipment/enable';
    const SMS_CUSTOMER_SHIPMENT_NOTIFICATION_TEMPLATE = 'whatsappbasic/shipment/template';


	public function isShipmentNotificationForUser() {
        return $this->isEnabled() && $this->scopeConfig->getValue(self::SMS_IS_CUSTOMER_SHIPMENT_NOTIFICATION,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid());
    }

    public function getShipmentNotificationUserTemplate()
    {
        if($this->isEnabled())
        {
            return  $this->scopeConfig->getValue(self::SMS_CUSTOMER_SHIPMENT_NOTIFICATION_TEMPLATE,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid());
        }
    }

    public function isShipmentNotificationForAdmin()
    {
        return $this->isEnabled() && $this->scopeConfig->getValue(self::SMS_IS_ADMIN_SHIPMENT_NOTIFICATION,
                ScopeInterface::SCOPE_STORE,
                $this->getStoreid());
    }

    public function getShipmentNotificationForAdminTemplate()
    {
        if($this->isEnabled())
        {
            return  $this->scopeConfig->getValue(self::SMS_ADMIN_SHIPMENT_NOTIFICATION_TEMPLATE,
                ScopeInterface::SCOPE_STORE,
                $this->getStoreid());
        }
    }
}