<?php
namespace Buckaroo;

use Buckaroo\Exceptions\UnsupportedPaymentMethodException;
use Buckaroo\Exceptions\UndefinedPaymentMethodException;
use Buckaroo\Exceptions\NegativeAmountException;
use Buckaroo\Exceptions\InvalidUrlException;
use Buckaroo\Service\ServiceInterface;
use Buckaroo\Transaction\ClientIp;
use Buckaroo\Transaction\Status;
use Buckaroo\Transaction\RequiredAction;
use Buckaroo\Transaction\Status\Code;
use DateTime;
use stdClass;
use ReflectionClass;

/**
 * This class manages transactions. The information is for both request and
 * response data. The execution of the transaction uses the request data to
 * set the response data.
 */
class Buckaroo
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Set necessary keys for Buckaroo API
     *
     * @param string $website
     * @param string $secret
     * @return Buckaroo
     */
    public function setApiKeys(string $website, string $secret): Buckaroo
    {
        $this->client->setWebsiteKey($website);
        $this->client->setSecretKey($secret);

        return $this;
    }

    /**
     * Client setter.
     *
     * @param ClientInterface $client
     * @return Buckaroo
     */
    public function setClient(ClientInterface $client): Buckaroo
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Client getter.
     *
     * @return Buckaroo
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Execute transaction
     *
     * @param Transaction $transaction
     * @return Buckaroo
     */
    public function execute(Transaction $transaction): Buckaroo
    {
        $response = json_decode($this->client->call((array) $transaction));
        $transaction->populate($response);

        return $this;
    }
}

