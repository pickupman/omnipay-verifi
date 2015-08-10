<?php

namespace Omnipay\Verifi\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Verifi Authorize Request
 */
class AuthorizeRequest extends AbstractVerifiRequest
{
    public function getData()
    {
        // An amount parameter is required.
        $this->validate('amount', 'transactionReference');

        $data = array(
            'amount'           => $this->getAmount(),
            'orderid'          => $this->getTransactionReference(),
            'ipaddress'        => $this->getClientIp(),
            'orderdescription' => '',
            'type'             => 'authorize'
        );

        // A card token can be provided if the card has been stored
        // in the gateway.
        if ($this->getCardReference()) {
            $data['transactionid'] = $this->getCardReference();

        // If no card token is provided then there must be a valid
        // card presented.
        } else {
            $this->validate('card');
            $card = $this->getCard();
            $card->validate();
            $data['firstname'] = $card->getBillingFirstName();
            $data['lastname']  = $card->getBillingLastName();
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
        }

        return $data;
    }

    /**
     * Get transaction endpoint.
     *
     * Purchases are created using the "sale" type.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint();
    }
}