<?php
namespace Buckaroo;

/**
 * This class holds information about the client calls
 */
class Client implements ClientInterface
{
    /**
     * @var string
     */
    private $websiteKey = '';

    /**
     * @var string
     */
    private $secretKey = '';

    /**
     * @var string
     */
    private $url = 'testcheckout.buckaroo.nl/json%s';

    /**
     * @var string
     */
    private $path = '';

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
    private $response = '';

    /**
     * WebsiteKey setter.
     *
     * @param string $websiteKey
     * @return Client
     */
    public function setWebsiteKey(string $websiteKey): Client
    {
        $this->websiteKey = $websiteKey;

        return $this;
    }

    /**
     * WebsiteKey getter.
     *
     * @return string
     */
    public function getWebsiteKey(): string
    {
        return $this->websiteKey;
    }

    /**
     * SecretKey setter.
     *
     * @param string $secretKey
     * @return Client
     */
    public function setSecretKey(string $secretKey): Client
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * SecretKey getter.
     *
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * Path setter.
     *
     * @param string $path
     * @return Client
     */
    public function setPath(string $path): Client
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Path getter.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Data setter.
     *
     * @param array $data
     * @return Client
     */
    public function setData(array $data): Client
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Data getter.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Response setter.
     *
     * @param string $response
     * @return Client
     */
    public function setResponse(string $response): Client
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Response getter.
     *
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * Call to Buckaroo api
     *
     * @return Client
     */
    public function call(): ClientInterface
    {
        $method = count($this->data) === 0 ? 'GET' : 'POST';
        $headers = [$this->getAuthorizationHeader($method, $this->data)];
        $body = json_encode($this->data);
        $ch = curl_init($this->getUrl());
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        $result = curl_exec($ch);
        curl_close($ch);

        $this->response = $result;

        return $this;
    }

    /**
     * Returns the decoded response, based on json_decode
     *
     * @return stdClass
     */
    public function getDecodedResponse(): \stdClass
    {
        return json_decode($this->response);
    }

    /**
     * AuthorizationHeader getter
     *
     * @param string $method
     * @param array  $this->data
     * @return string
     */
    private function getAuthorizationHeader(string $method): string
    {
        ksort($this->data);
        $post = base64_encode(md5(json_encode($this->data), true));
        $url = strtolower(urlencode($this->getUrl()));
        $nonce = sprintf('nonce_%d', mt_rand(0000000, 9999999));
        $time = time();
        $hmac = sprintf('%s%s%s%s%s%s', $this->websiteKey, $method, $url, $time, $nonce, $post);
        $s = hash_hmac('sha256', $hmac, $this->secretKey, true);
        $hmac = base64_encode($s);
        return sprintf('Authorization: hmac %s:%s:%s:%s', $this->websiteKey, $hmac, $nonce, $time);
    }

    /**
     * Builds the URL to call
     *
     * @return string
     */
    private function getUrl(): string
    {
        return sprintf($this->url, $this->path);
    }
}
