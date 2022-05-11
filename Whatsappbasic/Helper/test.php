<?php
namespace Magecomp\Mobilelogin\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\HTTP\Client\Curl;

/**
 * Class Apicall
 * Magecomp\Mobilelogin\Helper
 */
class Data extends AbstractHelper
{
    /**
     * Apicall constructor.
     * @param Curl $curl
     */
    public function __construct(
        Curl $curl
    ) {
        $this->curl = $curl;
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function curlApiCall()
    {
        try {
            if ($this->isEnable()) {
                $postData = [
                    'first_param' => 'first_value'
                ];

                $this->curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
                $this->curl->setOption(CURLOPT_SSL_VERIFYHOST, 2);
                $this->curl->post($this->getApiUrl(), $postData);
                // Response Text
                $response = $this->curl->getBody();
                // Response Header
                $responseHeader = $this->curl->getHeaders();
                // Response cookies
                $responseCookies = $this->curl->getCookies();
                return $response;
            }
        } catch (Exception $e) {
            $return = ["status"=>false, "message"=> $e->getMessage()];
        }
    }
}
