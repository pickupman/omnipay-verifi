<?php
/**
 * Verifi Purchase Request
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
 * * Customer IP (RFC standard IP address)
 *
 * Either
 *
 * * Card Holder (string)
 * * Card Number (string, numerical, 13 to 16 digits)
 * * Card Expiry (string, mm/yyyy format)
 * * CVV (numerical, 3 or 4 digits)
 *
 * Or
 *
 * * Card Token (String)
 *
 * Example:
 *
 * <code>
 *   // Create a gateway for the Verifi Gateway
 *   // (routes to GatewayFactory::create)
 *   $gateway = Omnipay::create('VerifiGateway');
 *
 *   // Initialise the gateway
 *   $gateway->initialize(array(
 *       'username' => 'TEST',
 *       'password' => 'TEST',
 *       'testMode' => true, // Or false when you are ready for live transactions
 *   ));
 *
 *   // Create a credit card object
 *   // This card can be used for testing.
 *   $card = new CreditCard(array(
 *               'firstName'    => 'Example',
 *               'lastName'     => 'Customer',
 *               'number'       => '4005550000000001',
 *               'expiryMonth'  => '01',
 *               'expiryYear'   => '2020',
 *               'cvv'          => '123',
 *   ));
 *
 *   // Do a purchase transaction on the gateway
 *   $transaction = $gateway->purchase(array(
 *       'amount'                   => '10.00',
 *       'transactionReference'     => 'TestPurchaseTransaction',
 *       'clientIp'                 => $_SERVER['REMOTE_ADDR'],
 *       'card'                     => $card,
 *   ));
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *       echo "Purchase transaction was successful!\n";
 *       $sale_id = $response->getTransactionReference();
 *       echo "Transaction reference = " . $sale_id . "\n";
 *   }
 * </code>
 *
 * @see Omnipay\Verifi\VerifiGateway
 */
class CreateCardRequest extends AbstractXmlRequest
{
    public function getData()
    {

        $data = array(
            'ipaddress'                 => $this->getClientIp(),
            'merchant_defined_field_1'  => '1',
            'merchant_defined_field_2'  => '0',
            'merchant_defined_field_12' => 'VAULT',
            'amount'                    => '0.00',
            'type'                      => 'verify'
        );

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
        $data['country']   = $card->getBillingCountry();
        $data['phone']     = $card->getBillingPhone();
        $data['zip']       = $card->getBillingPostcode();
        $data['email']     = $card->getEmail();

        return $data;
    }

    /**
     * Get transaction endpoint.
     *
     * Creating a card are created using the "verify" type.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint();
    }
}