<?php
/**
 * Verifi Void Request
 */

namespace Omnipay\Verifi\Message;

/**
 * Void Request
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
 *   $transaction = $gateway->void(array(
 *       'amount'                   => '10.00',
 *       'transactionReference'     => 'TestPurchaseTransaction'
 *   ));
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *       echo "Void transaction was successful!\n";
 *       $sale_id = $response->getTransactionReference();
 *       echo "Transaction reference = " . $sale_id . "\n";
 *   }
 * </code>
 *
 * @see Omnipay\Verifi\Gateway
 */
class VoidRequest extends AbstractVerifiRequest
{
    public function getData()
    {
        // An amount parameter is required.
        $this->validate('transactionReference');

        $data = array(
            'transactionid' => $this->getTransactionReference(),
            'type'          => 'void'
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