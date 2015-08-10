<?php

namespace Omnipay\Verifi\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Verifi Create Custom Subscription Request
 */
class CreateCustomSubscriptionRequest extends AbstractVerifiRequest
{
    public function getData()
    {

        $plan_amount   = ( $this->getPlanAmount() ) ? $this->getPlanAmount() : $this->getAmount();
        $plan_payments = ( $this->getPlanPayments() ) ? $this->getPlanPayments() : 0;
        $start_date    = ( $this->getStartDate() ) ? $this->getStartDate() : date("Ymd");

        $data = array(
            'recurring'     => 'add_subscription',
            'plan_amount'   => $this->getAmount(),
            'start_date'    => $start_date,
            'plan_payments' => $plan_payments,
            'payment'       => 'creditcard',
            'orderid'       => $this->getTransactionReference(),
        );

        if ( $this->getDayFrequency() && is_null($this->getMonthFrequency()) )
        {
            $data['day_frequency'] = $this->getDayFrequency();
        }

        if ( $this->getMonthFrequency() && $this->getDayOfMonth() )
        {
            $data['month_frequency'] = $this->getMonthFrequency();
            $data['day_of_month']    = $this->getDayOfMonth();
        }

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