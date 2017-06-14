<?php

namespace Omnipay\ApplePay;

use Omnipay\Common\AbstractGateway;

/**
 * Class AppleGateway
 * @package Omnipay\ApplePay
 */
class AppleGateway extends AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Apple_Pay_Apple';
    }


    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }


    public function getEnvironment()
    {
        return $this->getParameter('environment');
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


    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ApplePay\Message\ApplePurchaseRequest', $parameters);
    }


    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ApplePay\Message\AppleCompletePurchaseRequest', $parameters);
    }


    public function query(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ApplePay\Message\AppleQueryRequest', $parameters);
    }


    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ApplePay\Message\AppleRefundRequest', $parameters);
    }
}
