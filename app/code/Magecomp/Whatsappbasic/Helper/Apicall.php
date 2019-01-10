<?php 
namespace Magecomp\Whatsappbasic\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\ObjectManager;

class Apicall extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_SMSGATEWAY ='whatsappbasic/smsgatways/gateway';

    protected $smsgatewaylist;
    protected $_storeManager;

	public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                array $smsgatewaylist = [])
	{
        $this->smsgatewaylist = $smsgatewaylist;
        $this->_storeManager = $storeManager;
		parent::__construct($context);
	}

    public function getStoreid() {
        return $this->_storeManager->getStore()->getId();
    }

    public function getSmsgatewaylist()
    {
        return $this->smsgatewaylist;
    }

    public function getSelectedGateway() {
        return $this->scopeConfig->getValue(self::XML_PATH_SMSGATEWAY,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid());
    }

    public function getSelectedGatewayModel()
    {
        $Selectedgateway = $this->smsgatewaylist[$this->getSelectedGateway()];
        return ObjectManager::getInstance()->create($Selectedgateway);
    }
	
	public function callApiUrl($mobilenumbers,$message)
	{
		$curentsmsModel = $this->getSelectedGatewayModel();
        if(!$curentsmsModel){
		    $this->_logger->error(__("You haven't configured the WhatsApp Configuration."));
            return;
        }
		if(!$curentsmsModel->validateSmsConfig()){
		    $this->_logger->error(__("Please Configure all WhatsApp Configuration."));
            return;
        }
		return $curentsmsModel->callApiUrl($mobilenumbers,$message);
	}
}