<?php
namespace Magecomp\Wappcountryflag\Block;

class IntPhoneInput extends \Magento\Framework\View\Element\Template {

    protected $_helper;

    protected $_objectManager;
    protected $remoteaddress;
    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magecomp\Wappcountryflag\Helper\Data $helper,
    \Magento\Framework\ObjectManagerInterface $objectManager,
    \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteaddress,
    array $data = []
    ) {
        parent::__construct($context, $data);
        $this->remoteaddress=$remoteaddress;
        $this->_helper = $helper;
        $this->_objectManager = $objectManager;
    }

    public function getDetectByIp() {
        return $this->_helper->getDetectByIp();
    }

    public function getValidatePhone() {
        return $this->_helper->getValidatePhone();
    }

    public function getDefualtCountry(){
        return $this->_helper->getDefualtCountry();
    }

    public function getDefaultCountryCodeNumber(){
        return $this->_helper->getDefaultCountryCodeNumber();
    }
    public function getCustomerIPAddress() {
        $local = ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1' ) ? true : false;
        if ( $local ) {
            return '8.8.8.8';
        }
        return $this->remoteaddress->getRemoteAddress();


    }
    public function getCustomerIPDetails() {
        return  $this->_helper->getCustomerIPDetails();;
    }


}
