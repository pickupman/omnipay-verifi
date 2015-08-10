<?php

namespace Omnipay\Verifi\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Verifi Update Subscription Request
 */
class UpdateSubscriptionRequest extends AbstractVerifiRequest
{
    public function getData()
    {
        // An amount parameter is required.
        $this->validate('subscription_id');

        $data = array(
            'recurring'        => 'update_subscription',
            'subscription_id'  => $this->getSubscriptionId(),
            'start_date'       => $this->getStartDate(),
            'payment'          => 'creditcard',
            'orderid'          => $this->getTransactionReference(),
        );

        if ( $this->getCustomerReceipt() )
        {
            $data['customer_receipt'] = $this->getCustomerReceipt();
        }

        $this->validate('card');
        $card = $this->getCard();
        $card->validate();
        $data['first_name'] = $card->getBillingFirstName();
        $data['last_name']  = $card->getBillingLastName();
        $data['company']   = $card->getBillingCompany();
        $data['ccnumber']  = $card->getNumber();
        $data['ccexp']     = $card->getExpiryDate('m/Y');
        $data['cvv']       = $card->getCvv();
        $data['address1']  = $card->getBillingAddress1();
        $data['address2']  = $card->getBillingAddress2();
        $data['city']      = $card->getBillingCity();
        $data['state']     = $card->getBillingState();
        $data['zip']       = $card->getBillingPostcode();
        $data['country']   = $card->getBillingCountry();
        $data['phone']     = $card->getBillingPhone();
        $data['email']     = $card->getEmail();

        return $data;
    }
}