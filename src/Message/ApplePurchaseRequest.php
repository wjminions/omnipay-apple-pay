<?php

namespace Omnipay\ApplePay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\ApplePay\Helper;

/**
 * Class ApplePurchaseRequest
 * @package Omnipay\ApplePay\Message
 */
class ApplePurchaseRequest extends AbstractAppleRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validateData();

        $data = array (
            //商户订单号
            'order_id'        => $this->getOrderId(),
            //交易金额，单位分
            'amount'         => $this->getAmount()
        );

        return $data;
    }


    private function validateData()
    {
        $this->validate(
            'order_id',
            'amount'
        );
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
        return $this->response = new ApplePurchaseResponse($this, $data);
    }
}
