<?php

namespace Omnipay\Verifi\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Verifi Capture Request
 */
class CaptureRequest extends AbstractVerifiRequest
{
    public function getData()
    {
        // An amount parameter is required.
        $this->validate('amount', 'transactionReference');

        $data = array(
            'amount'           => $this->getAmount(),
            'transactionid'    => $this->getTransactionReference(),
            'type'             => 'capture'
        );

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