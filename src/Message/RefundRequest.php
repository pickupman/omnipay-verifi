<?php
/**
 * Verifi Refund Request
 */

namespace Omnipay\Verifi\Message;

/**
 * Fat Zebra REST Purchase Request
 *
 * In order to create a purchase you must submit the following details:
 *
 * * Amount (numerical)
 * * Reference (string - maximum 30 characters) -- this must be unique.  More
 *   than one transaction using the same Reference value will raise an error.
 *
 * * Card Token (String)
 *
 * Example:
 *
 * <code>
 *   // Create a gateway for the Verifi Gateway
 *   // (routes to GatewayFactory::create)
 *   $gateway = Omnipay::create('Verifi');
 *
 *   // Initialise the gateway
 *   $gateway->initialize(array(
 *       'username' => 'TEST',
 *       'password' => 'TEST',
 *       'testMode' => true, // Or false when you are ready for live transactions
 *   ));
 *
 *   // Do a purchase transaction on the gateway
 *   $transaction = $gateway->refund(array(
 *       'amount'                   => '10.00',
 *       'transactionReference'     => 'TestPurchaseTransaction'
 *   ));
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *       echo "Refund transaction was successful!\n";
 *       $sale_id = $response->getTransactionReference();
 *       echo "Transaction reference = " . $sale_id . "\n";
 *   }
 * </code>
 *
 * @see Omnipay\Verifi\VerifiGateway
 */
class RefundRequest extends AbstractXmlRequest
{
    public function getData()
    {
        // An amount parameter is required.
        $this->validate('amount', 'transactionReference');

        $data = array(
            'amount'        => $this->getAmount(),
            'transactionid' => $this->getTransactionReference(),
            'type'          => 'refund',
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