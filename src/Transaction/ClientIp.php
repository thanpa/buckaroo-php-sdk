<?php
namespace Buckaroo\Transaction;

/**
 * This class holds information about the client IP.
 * Type is 0 when IPv4 and 1 when IPv6.
 * The IP is stored in it's normal human readable format.
 */
class ClientIp
{
    /**
     * @var int
     */
    private $type = 0;

    /**
     * @var string
     */
    private $address = '';

    /**
     * Type setter.
     *
     * @param int $type
     * @return ClientIp
     */
    public function setType(int $type): ClientIp
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Type getter.
     *
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * Address setter.
     *
     * @param string $address
     * @return ClientIp
     */
    public function setAddress(string $address): ClientIp
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Address getter.
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }
}
