<?php
namespace Buckaroo;

use Buckaroo\Transaction;
use Buckaroo\Validators\Validator;

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
        $this->validator = new Validator();
    }

    /**
     * Set necessary keys for Buckaroo API
     *
     * @param string $website The website
     * @param string $secret The secret
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
     * @param ClientInterface $client The client
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
     * Retrieves a transaction.
     *
     * @param string $key The key
     * @return Transaction
     */
    public function getTransaction(string $key): Transaction
    {
        $this->client->setPath(sprintf('/transaction/status/%s', $key));
        $transaction = new Transaction();
        $transaction->populate($this->client->call()->getDecodedResponse());

        return $transaction;
    }

    /**
     * Populates a transaction from a buckaroo push.
     *
     * @param string $pushBody The body from the push from Buckaroo
     * @return Transaction
     */
    public function populateFromPush(string $pushBody): Transaction
    {
        $decoded = json_decode($pushBody);

        $transaction = new Transaction();
        $transaction->populate($decoded->Transaction);

        return $transaction;
    }

    /**
     * Execute transaction
     *
     * @param Transaction $transaction The transaction to execute
     * @return Buckaroo
     */
    public function execute(Transaction $transaction): Buckaroo
    {
        $this->validator->validateTransaction($transaction);
        $this->client->setPath('/transaction')->setData($transaction->toArray());
        $transaction->populate($this->client->call()->getDecodedResponse());

        return $this;
    }
}
