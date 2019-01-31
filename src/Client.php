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
    private $url = 'https://testcheckout.buckaroo.nl/json/Transaction';

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
     * Call to Buckaroo api
     *
     * @param array $data
     * @return string
     */
    public function call(array $data = []): string
    {
        $method = count($data) === 0 ? 'GET' : 'POST';
        $headers = [$this->getAuthorizationHeader($method, $data)];
        $body = json_encode($data);
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * AuthorizationHeader getter
     *
     * @param string $method
     * @param array  $data
     * @return string
     */
    private function getAuthorizationHeader(string $method, array $data): string
    {
        ksort($data);
        $post = base64_encode(md5(json_encode($data), true));

        $url = strtolower(urlencode($this->url));
        $nonce = sprintf('nonce_%d', mt_rand(0000000, 9999999));
        $time = time();

        $hmac = sprintf('%s%s%s%s%s%s', $this->websiteKey, $method, $url, $time, $nonce, $post);
        $s = hash_hmac('sha256', $hmac, $this->secretKey, true);
        $hmac = base64_encode($s);

        return sprintf('"hmac %s:%s:%s:%s', $this->websiteKey, $hmac, $nonce, $time);
    }
}
