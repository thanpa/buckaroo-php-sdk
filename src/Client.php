<?php
namespace Buckaroo;

class Client implements ClientInterface
{
    private $websiteKey = '';
    private $secretKey = '';
    private $url = 'https://testcheckout.buckaroo.nl/json/Transaction';

    public function setWebsiteKey($websiteKey)
    {
        $this->websiteKey = $websiteKey;

        return $this;
    }

    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    public function call(array $data = [])
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
