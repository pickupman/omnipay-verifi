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
        return $this->data['responsetext'] == 'SUCCESS';
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
     * Get a customer reference, for createCustomer requests.
     *
     * @return string|null
     */
    public function getCustomerReference()
    {
        if (isset($this->data['object']) && 'customer' === $this->data['object']) {
            return $this->data['id'];
        }
        if (isset($this->data['object']) && 'card' === $this->data['object']) {
            if (! empty($this->data['customer'])) {
                return $this->data['customer'];
            }
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
        if (isset($this->data['object']) && 'customer' === $this->data['object']) {
            if (! empty($this->data['default_card'])) {
                return $this->data['default_card'];
            }
            if (! empty($this->data['id'])) {
                return $this->data['id'];
            }
        }
        if (isset($this->data['object']) && 'card' === $this->data['object']) {
            if (! empty($this->data['id'])) {
                return $this->data['id'];
            }
        }

        return null;
    }

    /**
     * Get a token, for createCard requests.
     *
     * @return string|null
     */
    public function getToken()
    {
        if (isset($this->data['object']) && 'token' === $this->data['object']) {
            return $this->data['id'];
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