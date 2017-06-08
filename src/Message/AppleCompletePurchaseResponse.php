<?php

namespace Omnipay\ApplePay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class AppleCompletePurchaseResponse
 * @package Omnipay\ApplePay\Message
 */
class AppleCompletePurchaseResponse extends AbstractResponse
{

    public function isPaid()
    {
        return $this->data['is_paid'];
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['verify_success'];
    }
}
