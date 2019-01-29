<?php
namespace Buckaroo\Transaction;

class ClientIp
{
    private $type = '';
    private $address = '';

    public function setType(string $type): ClientIp
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setAddress(string $address): ClientIp
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}
