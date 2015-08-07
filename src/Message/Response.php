<?php
/**
 * Verifi Response
 */

namespace Omnipay\Verifi\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Verifi Response
 *
 * This is the response class for all Verifi requests.
 *
 * @see \Omnipay\Verifi\Gateway
 */
class Response extends AbstractResponse
{
    /**
     * Is the transaction successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        if ( isset($this->data['response']) && isset($this->data['response_code']) )
        {
            return (bool)($this->data['response'] == '1' && $this->data['response_code'] == '100');
        }

        return false;
    }

    /**
     * Get the transaction reference.
     *
     * @return string|null
     */
    public function getTransactionReference()
    {
        if (isset($this->data['transactionid'])) {
            return $this->data['transactionid'];
        }

        return null;
    }



    /**
     * Get a card reference, for createCard or createCustomer requests.
     *
     * @return string|null
     */
    public function getCardReference()
    {


        return null;
    }

    /**
     * Get a token, for createCard requests.
     *
     * @return string|null
     */
    public function getToken()
    {
        if ( $this->isSuccessful() )
        {
            return $this->data['transactionid'];
        }
        return null;
    }

    /**
     * Get the card data from the response.
     *
     * @return array|null
     */
    public function getCard()
    {
        if (isset($this->data['card'])) {
            return $this->data['card'];
        }

        return null;
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getMessage()
    {
        if (!$this->isSuccessful()) {
            return $this->data['responsetext'];
        }

        return null;
    }
}