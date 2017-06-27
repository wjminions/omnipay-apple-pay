<?php

namespace Omnipay\ApplePay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\ApplePay\Helper;

/**
 * Class AppleCompletePurchaseRequest
 * @package Omnipay\ApplePay\Message
 */
class AppleCompletePurchaseRequest extends AbstractAppleRequest
{
    protected $sandboxEndpoint = 'https://sandbox.itunes.apple.com/';

    protected $productionEndpoint = 'https://buy.itunes.apple.com/';

    protected $methods = array (
        'query' => 'verifyReceipt',
    );


    public function getEndpoint($type)
    {
        if ($this->getEnvironment() == 'production') {
            return $this->productionEndpoint . $this->methods[$type];
        } else {
            return $this->sandboxEndpoint . $this->methods[$type];
        }
    }


    public function getEnvironment()
    {
        return $this->getParameter('environment');
    }


    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->getRequestParams();
    }


    public function setRequestParams($value)
    {
        $this->setParameter('request_params', $value);
    }


    public function getRequestParams()
    {
        return $this->getParameter('request_params');
    }


    public function getRequestParam($key)
    {
        $params = $this->getRequestParams();
        if (isset($params[$key])) {
            return $params[$key];
        } else {
            return null;
        }
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $url = $this->getEndpoint('query');

        Helper::validateApplePay($data, $url);


        $data['is_paid']        = $data['verify_success'] && ($this->getRequestParam('respCode') == '00');

        return $this->response = new AppleCompletePurchaseResponse($this, $data);
    }
}
