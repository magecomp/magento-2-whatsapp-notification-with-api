<?php 
namespace Magecomp\Whatsappbasic\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    // GENERAL Configuration
	const XML_PATH_ENABLED ='whatsappbasic/moduleoption/enable';

    // USER TEMPLATE configuration
 	const XML_SMS_USER_ORDER_PLACE_ENABLE = 'whatsappbasic/orderplace/enable';
 	const XML_SMS_USER_USER_ORDER_PLACE_TEXT = 'whatsappbasic/orderplace/template';
	const XML_SMS_USER_SHIPMENT_ENABLE = 'whatsappbasic/shipment/enable';
	const XML_SMS_USER_SHIPMENT_TEXT = 'whatsappbasic/shipment/template';

	protected $_storeManager;

	public function __construct(
	\Magento\Framework\App\Helper\Context $context,
	\Magento\Framework\ObjectManagerInterface $objectManager,
	\Magento\Framework\Registry $registry,
	\Magento\Store\Model\StoreManagerInterface $storeManager)
	{
		$this->registry = $registry;
		$this->_storeManager = $storeManager;
		parent::__construct($context);
	}

    public function getStoreid()
    {
        return $this->_storeManager->getStore()->getId();
    }

	public function isEnabled()
	{
        return $this->scopeConfig->getValue(self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid());
    }

	public function isOrderPlaceForUserEnabled()
	{
        return $this->scopeConfig->getValue(self::XML_SMS_USER_ORDER_PLACE_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid());
    }
	public function getOrderPlaceTemplateForUser()
	{
        return $this->scopeConfig->getValue(self::XML_SMS_USER_USER_ORDER_PLACE_TEXT,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid());
    }

	public function isShipmentEnabledForUser()
	{
        return $this->scopeConfig->getValue(self::XML_SMS_USER_SHIPMENT_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid());
    }
	public function getShipmenTemplateForUser()
	{
        return $this->scopeConfig->getValue(self::XML_SMS_USER_SHIPMENT_TEXT,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid());
    }
}