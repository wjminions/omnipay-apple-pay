<?php

namespace Omnipay\ApplePay\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\ApplePay\Helper;

/**
 * Class AbstractAppleRequest
 * @package Omnipay\ApplePay\Message
 */
abstract class AbstractAppleRequest extends AbstractRequest
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


    public function setOrderId($value)
    {
        return $this->setParameter('order_id', $value);
    }


    public function getOrderId()
    {
        return $this->getParameter('order_id');
    }


    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }


    public function getAmount()
    {
        return $this->getParameter('amount');
    }
}
