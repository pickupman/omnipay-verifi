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
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
    * Set the gateway password
    *
    * @return string
    */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
    * Get the level of continuity for recurring billing
    *
    * @return string
    */
    public function getLevelOfContinuity()
    {
        return $this->getParameter('level_of_continuity');
    }

    /**
    *  Set the level of continuity for recurring billing
    *
    * @param string
    */
    public function setLevelOfContinuity($value)
    {
        return $this->setParameter('level_of_continuity', $value);
    }

    /**
    * Get the subscription plan id
    *
    * @param string
    */
    public function getPlanId($value)
    {
        return $this->getParameter('plan_id');
    }

    /**
    * Set the subscription plan id
    *
    * @param string
    */
    public function setPlanId($value)
    {
        return $this->setParameter('plan_id', $value);
    }

    /**
    * Get the start date for a subscription
    *
    * @param string YYYYMMDD
    */
    public function getStartDate()
    {
        return $this->getParameter('start_date', date("Ymd"));
    }

    /**
    * Set the start date for a subscription
    *
    * @param string YYYYMMDD
    */
    public function setStartDate($value)
    {
        return $this->setParameter('start_date', $value);
    }

    /**
    * Get the send customer receipt flag
    *
    * @param string
    */
    public function getCustomerReceipt()
    {
        return $this->getParameter('customer_receipt');
    }

    /**
    * Set the send customer receipt flag
    *
    * @param string
    */
    public function setCustomerReceipt($value)
    {
        return $this->setParameter('customer_receipt', $value);
    }

    /**
    * Get the number of plan payments
    * Defaults to 0 = billed until cancelled
    *
    * @param string
    */
    public function getPlanPayments()
    {
        return $this->getParameter('plan_payments', '0');
    }

    /**
    * Set the number of payments the customer will be bill
    * Passing "0" will bill customer until canceled.
    *
    * @param string
    */
    public function setPlanPayments($value)
    {
        return $this->setParameter('plan_payments', $value);
    }

    /**
    * Get the plan amount that will be billed
    *
    * @param string
    */
    public function getPlanAmount()
    {
        return $this->getParameter('plan_amount');
    }

    /**
    * Set the plan amount customer will be billed each cycle
    *
    * @param string
    */
    public function setPlanAmount($value)
    {
        return $this->setParameter('plan_amount', $value);
    }

    /**
    * Get the daily frequency billing option
    *
    * @param string
    */
    public function getDayFrequency()
    {
        return $this->getParameter('day_frequency');
    }

    /**
    * Set the billing frequency on a daily schedule
    * NOT to be used with month_frequency
    *
    * @param string
    */
    public function setDayFrequency($value)
    {
        return $this->setParameter('day_frequency', $value);
    }

    /**
    * Get the monthly billing frequency
    *
    * @param string
    */
    public function getMonthFrequency()
    {
        return $this->getParameter('month_frequency');
    }

    /**
    * Set the monthly billing frequency
    * NOT to be used with day_frequency
    * Valid values are 1 - 24
    *
    * @param string
    */
    public function setMonthFrequency($value)
    {
        return $this->setParameter('month_frequency', $value);
    }

    /**
    * Get the day of the month billing will occur on
    *
    * @param string
    */
    public function getDayOfMonth()
    {
        return $this->getParameter('day_frequency');
    }

    /**
    * Set the day of the month billing will occur on
    * USED with month_frequency
    * Valid values are 1 - 31. If value is greater than the number
    * of days in a month, billing will occur on last day of that month
    *
    * @param string
    */
    public function setDayOfMonth($value)
    {
        return $this->setParameter('day_frequency', $value);
    }

    /**
    * Get the subscription id
    *
    * @param string
    */
    public function getSubscriptionId()
    {
        return $this->getParameter('subscription_id');
    }

    /**
    * Set the subscription id
    *
    * @param string
    */
    public function setSubscriptionId($value)
    {
        return $this->setParameter('subscription_id', $value);
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
            $data['username'] = 'demo';
            $data['password'] = 'password';
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