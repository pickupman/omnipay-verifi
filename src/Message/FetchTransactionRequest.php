<?php

namespace Omnipay\Verifi\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Verifi Delete Subscription Request
 */
class FetchTransactionRequest extends AbstractVerifiRequest
{

    public function getData()
    {

        $this->liveEndpoint = $this->queryEndpoint;

        // An amount parameter is required.
        $this->validate('transactionReference');

        $data = array(
            'transaction_id'  => $this->getTransactionReference()
        );

        if ( $this->getCustomerReceipt() )
        {
            $data['customer_receipt'] = $this->getCustomerReceipt();
        }

        return $data;
    }
}