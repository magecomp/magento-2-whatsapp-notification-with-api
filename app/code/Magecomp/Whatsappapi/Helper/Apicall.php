<?php 
namespace Magecomp\Whatsappapi\Helper;

class Apicall extends \Magento\Framework\App\Helper\AbstractHelper
{

    const XML_WHATSAPP_API_AUTHKEY = 'whatsappbasic/smsgatways/whatsappapitoken';
	const XML_WHATSAPP_API_URL = 'whatsappbasic/smsgatways/whatsappapiurl';

	public function __construct(\Magento\Framework\App\Helper\Context $context)
	{
		parent::__construct($context);
	}

    public function getTitle() {
        return __("WhatsApp API");
    }

    public function getAuthToken()	{
        return $this->scopeConfig->getValue(
            self::XML_WHATSAPP_API_AUTHKEY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

	public function getApiUrl()	{
		return $this->scopeConfig->getValue(
            self::XML_WHATSAPP_API_URL,
			 \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
	}

	public function validateSmsConfig()
    {
        return $this->getApiUrl() && $this->getAuthToken() ;
    }
	
	public function callApiUrl($mobilenumbers,$message)
	{
		  $url = $this->getApiUrl();
		  $authtoken = $this->getAuthToken();
  	  	  $message = urlencode($message);
		  
		  $ch = curl_init();
		  if (!$ch)
		  {
			  return "Couldn't initialize a cURL handle";
		  }
		 $ret = curl_setopt($ch, CURLOPT_URL,"$url?token=$authtoken&message=$message&to=$mobilenumbers");
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		 $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 $curlresponse = curl_exec($ch); // execute
		 $curl_info = curl_getinfo($ch);
		  
		  if ($curlresponse == FALSE)
		  {
			  return "cURL error: ".curl_error($ch);
		  }
		  elseif($curl_info['http_code'] != '200')
		  {
			  return "Error: non-200 HTTP status code: ".$curl_info['http_code'];
		  }
		  else
		  {
				  return true;
		  }
		  curl_close($ch);
		return $curlresponse;
	}
}