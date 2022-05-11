<?php
namespace Magecomp\Whatsappapi\Helper;

class Apicall extends \Magento\Framework\App\Helper\AbstractHelper
{

    const XML_WHATSAPP_API_CLIENT_ID = 'whatsappbasic/smsgatways/whatsappapiclientid';
    const XML_WHATSAPP_API_INSTANCE = 'whatsappbasic/smsgatways/whatsappapiinstance';
	const XML_WHATSAPP_API_URL = 'whatsappbasic/smsgatways/whatsappapiurl';



	public function __construct(\Magento\Framework\App\Helper\Context $context)
	{
		parent::__construct($context);
	}

    public function getTitle() {
        return __("WhatsApp API");
    }

    public function getClientId()
    {
        return $this->scopeConfig->getValue(
            self::XML_WHATSAPP_API_CLIENT_ID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getInstanceId()
    {
        return $this->scopeConfig->getValue(
            self::XML_WHATSAPP_API_INSTANCE,
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
        return $this->getApiUrl() && $this->getClientId() && $this->getInstanceId();
    }

	public function callApiUrl($mobilenumbers,$message)
	{
		  $url = $this->getApiUrl();
        $instance = $this->getInstanceId();
        $clientId = $this->getClientId();
        $message = urlencode($message);
        $paramString = sprintf("client_id=%s&instance=%s&type=text&number=%s&message=%s", $clientId, $instance, $mobilenumbers, $message);

		  $ch = curl_init();
		  if (!$ch)
		  {
			  return "Couldn't initialize a cURL handle";
		  }
		 $ret = curl_setopt($ch, CURLOPT_URL, $url . "?" . $paramString);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		 $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 $curlresponse = curl_exec($ch); // execute
		 $curl_info = curl_getinfo($ch);
        $result =  json_decode($curlresponse);
		  if ($curlresponse == FALSE)
		  {
			  return "cURL error: ".curl_error($ch);
		  }
		  elseif($curl_info['http_code'] != '200')
		  {
			  return "Error: non-200 HTTP status code: ".$curl_info['http_code'];
		  } elseif (array_key_exists('error', $result)) {
              return "Error: " . $result['message'];
          }
          else
		  {
				  return true;
		  }
		  curl_close($ch);
		return $curlresponse;
	}
}
