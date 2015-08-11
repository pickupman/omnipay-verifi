<?php

namespace Omnipay\Verifi;

use Omnipay\Common\AbstractGateway;
use Omnipay\Verifi\Message\AuthorizeRequest;

/**
 * Verifi Gateway
 *
 * This gateway is useful for testing. It simply authorizes any payment made using a valid
 * credit card number and expiry.
 *
 * Any card number which passes the Luhn algorithm and ends in an even number is authorized,
 * for example: 4242424242424242
 *
 * Any card number which passes the Luhn algorithm and ends in an odd number is declined,
 * for example: 4111111111111111
 */
class Gateway extends AbstractGateway
{
    /**
     * Get the gateway display name
     *
     * @return string
     */
    public function getName()
    {
        return 'Verifi v1.0';
    }

    /**
     * Get the gateway default parameters
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
                'username' => '',
                'password' => '',
                'type'     => '',
                'testMode' => false
            );
    }

    /**
     * Get the gateway username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * Set the gateway username
     *
     * @return VerifiGateway provides a fluent interface.
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Set the getway password
     *
     * @param string password
     * @return string
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Get the gateway password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Create a authorize request.
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Create a capture request.
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\CaptureRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\CaptureRequest', $parameters);
    }

    /**
     * Create a purchase request.
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\PurchaseRequest', $parameters);
    }

    /**
     * Refund a purchase
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\RefundRequest', $parameters);
    }

    /**
     * Tokenize a card
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\CreateCardRequest
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\CreateCardRequest', $parameters);
    }

    /**
     * Tokenize a card
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\CreateCardRequest
     */
    public function updateCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\CreateCardRequest', $parameters);
    }

    /**
     * Tokenize a card
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\CreateCardRequest
     */
    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\VoidRequest', $parameters);
    }


     /**
     * Create a customer
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\CreateCustomerRequest
     */
    public function createCustomer(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\CreateCustomerRequest', $parameters);
    }

    /**
     * Fetch details of a customer
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\FetchCustomerRequest
     */
    public function fetchCustomer(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\FetchCustomerRequest', $parameters);
    }

    /**
     * Delete a customer
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\DeleteCustomerRequest
     */
    public function deleteCustomer(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\DeleteCustomerRequest', $parameters);
    }

    /**
     * Create a subscription
     *
     * A subscription is an instance of a customer subscribing to a plan.
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\CreateSubscriptionRequest
     */
    public function createSubscription(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\CreateSubscriptionRequest', $parameters);
    }

    /**
     * Create a custom subscription
     *
     * A subscription is an instance of a customer subscribing to a plan.
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\CreateCustomSubscriptionRequest
     */
    public function createCustomSubscription(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\CreateCustomSubscriptionRequest', $parameters);
    }

    /**
     * Update billing information of a subscription
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\UpdateSubscriptionRequest
     */
    public function updateSubscription(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\UpdateSubscriptionRequest', $parameters);
    }

    /**
     * Update billing information of a subscription
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\UpdateSubscriptionRequest
     */
    public function deleteSubscription(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\DeleteSubscriptionRequest', $parameters);
    }

    /**
     * Fetch details of a customer
     *
     * @param array $parameters
     * @return \Omnipay\Verifi\Message\FetchCustomerRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Verifi\Message\FetchTransactionRequest', $parameters);
    }

}