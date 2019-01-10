<?php
namespace Magecomp\Whatsappbasic\Observer;
 
use Magento\Framework\Event\ObserverInterface;

class Orderplaceafter implements ObserverInterface
{
    protected $objectManager;
	protected $helperdata;
    protected $helperapi;
    protected $emailfilter;
    protected $customerFactory;

	public function __construct(
	    \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magecomp\Whatsappbasic\Helper\Data $helperdata,
        \Magecomp\Whatsappbasic\Helper\Apicall $helperapi,
        \Magento\Email\Model\Template\Filter $filter,
        \Magento\Customer\Model\CustomerFactory $customerFactory)
    {
        $this->objectManager = $objectManager;
        $this->helperdata = $helperdata;
        $this->helperapi = $helperapi;
        $this->emailfilter = $filter;
        $this->customerFactory = $customerFactory;

    }
 
	public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try
        {
            if($this->helperdata->isEnabled() && $this->helperdata->isOrderPlaceForUserEnabled())
            {
		         $order_id = $observer->getData('order_ids');
                $order = $this->objectManager->create('Magento\Sales\Model\Order')->load($order_id[0]);
                $order_information = $order->loadByIncrementId($order_id[0]);

                $billingAddress = $order_information->getBillingAddress();
                $mobilenumber = $billingAddress->getTelephone();
		        if($order->getCustomerId() > 0)
                {
		            $customer = $this->customerFactory->create()->load($order_information->getCustomerId());
                    $mobile = $customer->getMobilenumber();
                    if($mobile != '' && $mobile != null)
                    {
		                $mobilenumber = $mobile;
                    }
		            $this->emailfilter->setVariables([
                        'order' => $order,
                        'customer' => $customer,
                        'order_total' => $order->formatPriceTxt($order->getGrandTotal()),
                        'mobilenumber' => $mobilenumber
                    ]);
		        }else{
		            $this->emailfilter->setVariables([
                        'order' => $order,
                        'order_total' => $order->formatPriceTxt($order->getGrandTotal()),
                        'mobilenumber' => $mobilenumber
                    ]);
		        }
		        $message = $this->helperdata->getOrderPlaceTemplateForUser();
                $finalmessage = $this->emailfilter->filter($message);
		        $this->helperapi->callApiUrl($mobilenumber,$finalmessage);
		    }
		    return true;
	    }
	    catch(\Exception $e)
        {
		    return true;
	    }
   }
}