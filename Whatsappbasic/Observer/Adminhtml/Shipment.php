<?php
namespace Magecomp\Whatsappbasic\Observer\Adminhtml;

use Magento\Framework\Event\ObserverInterface;

class Shipment implements ObserverInterface
{
    protected $objectManager;
    protected $helperapi;
    protected $emailfilter;
    protected $customerFactory;
	protected $helpershipment;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magecomp\Whatsappbasic\Helper\Apicall $helperapi,
        \Magento\Email\Model\Template\Filter $filter,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
		\Magecomp\Whatsappbasic\Helper\Shipment $helpershipment)
    {
        $this->objectManager = $objectManager;
        $this->helperapi = $helperapi;
        $this->emailfilter = $filter;
        $this->customerFactory = $customerFactory;
     	$this->helpershipment = $helpershipment;
    }
	 
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        if(!$this->helpershipment->isEnabled())
            return $this;

        $shipment   = $observer->getShipment();
        $order      = $shipment->getOrder();

        if($shipment)
        {
            $billingAddress = $order->getBillingAddress();
            $mobilenumber = $billingAddress->getTelephone();

            if($order->getCustomerId() > 0)
            {
                $customer = $this->customerFactory->create()->load($order->getCustomerId());
                $mobile = $customer->getMobilenumber();
                if($mobile != '' && $mobile != null)
                {
                    $mobilenumber = $mobile;
                }

                $this->emailfilter->setVariables([
                    'order' => $order,
                    'shipment' => $shipment,
                    'customer' => $customer,
                    'mobilenumber' => $mobilenumber
                ]);
            }
            else
            {
                $this->emailfilter->setVariables([
                    'order' => $order,
                    'shipment' => $shipment,
                    'mobilenumber' => $mobilenumber
                ]);
            }

            if ($this->helpershipment->isShipmentEnabledForUser())
            {
                $message = $this->helpershipment->getShipmentNotificationUserTemplate();
                $finalmessage = $this->emailfilter->filter($message);
                $this->helperapi->callApiUrl($mobilenumber,$finalmessage);
            }


        }
        return $this;

    }
}