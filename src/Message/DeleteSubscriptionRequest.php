<?php

namespace Omnipay\Verifi\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Verifi Delete Subscription Request
 */
class DeleteSubscriptionRequest extends AbstractVerifiRequest
{
    public function getData()
    {
        // An amount parameter is required.
        $this->validate('subscription_id');

        $data = array(
            'recurring'        => 'delete_subscription',
            'subscription_id'  => $this->getSubscriptionId()
        );

        if ( $this->getCustomerReceipt() )
        {
            $data['customer_receipt'] = $this->getCustomerReceipt();
        }

        return $data;
    }
}