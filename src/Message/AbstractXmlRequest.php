<?php
/**
 * Verifi Abstract XML Request
 */
namespace Omnipay\Verifi\Message;
use Guzzle\Http\EntityBody;
use Guzzle\Stream\PhpStreamRequestFactory;
/**
 * Verifi Abstract XML Request
 *
 * This is the parent class for all Fat Zebra REST requests.
 *
 * Test modes:
 *
 * There are two test modes in the Paystream system - one is a
 * sandbox environment and the other is a test mode flag.
 *
 * The Sandbox Environment is an identical copy of the live environment
 * which is 100% functional except for communicating with the banks.
 *
 * The Test Mode Flag is used to switch the live environment into
 * test mode. If test: true is sent with your request your transactions
 * will be executed in the live environment, but not communicate with
 * the bank backends. This mode is useful for testing changes to your
 * live website.
 *
 * Currently this class makes the assumption that if the testMode
 * flag is set then the Sandbox Environment is being used.
 *
 * @see \Omnipay\Verifi\VerifiGateway
 */
abstract class AbstractXmlRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const API_VERSION = 'v1.0';
    /**
     * Sandbox Endpoint URL
     *
     * @var string URL
     */
    protected $testEndpoint = 'https://secure.verifi.com/gw/api/transact.php';
    /**
     * Live Endpoint URL
     *
     * @var string URL
     */
    protected $liveEndpoint = 'https://secure.verifi.com/gw/api/transact.php';
    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * Get API endpoint URL
     *
     * @return string
     */
    protected function getEndpoint()
    {
        $base = $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
        return $base;
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
     * @return AbstractRestRequest provides a fluent interface.
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
    * Get the gateway password
    *
    * @return string
    */
    public function getPassword(){
        return $this->getParameter('password');
    }

    /**
    * Set the gateway password
    *
    * @return string
    */
    public function setPassword($value){
        return $this->setParameter('password', $value);
    }

    /**
    * Process request
    *
    * @return mixed
    */
    public function sendData($data)
    {
        if ( true == $this->getParameter('testMode') )
        {
            $data['username'] = 'testintegration';
            $data['password'] = 'password9';
        }
        else
        {
            $data['username'] = $this->getUsername();
            $data['password'] = $this->getPassword();
        }


        // don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            null,
            $data
        );

        // Might be useful to have some debug code here.  Perhaps hook to whatever
        // logging engine is being used.
        // echo "Data == " . json_encode($data) . "\n";
        //$httpResponse = $httpRequest->send();

        $factory = new PhpStreamRequestFactory();
        $stream = $factory->fromRequest($httpRequest);

        // Read until the stream is closed
        while (!$stream->feof()) {
            // Read a line from the stream
            $line = $stream->readLine();
            // JSON decode the line of data
        }
        parse_str($line, $output);

        return $this->response = new Response($this, $output, $factory->getLastResponseHeaders());
    }

}