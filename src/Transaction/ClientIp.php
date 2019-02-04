<?php
namespace Buckaroo\Transaction;

use Buckaroo\Exceptions\UnsupportedClientIpTypeException;
use Buckaroo\Exceptions\InvalidIpAddressException;

/**
 * This class holds information about the client IP.
 * Type is 0 when IPv4 and 1 when IPv6.
 * The IP is stored in it's normal human readable format.
 */
class ClientIp
{
    const TYPE_IPV4 = 0;
    const TYPE_IPV6 = 1;
    const VALID_TYPES = [self::TYPE_IPV6, self::TYPE_IPV4];

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
        if (!in_array($type, self::VALID_TYPES)) {
            throw new UnsupportedClientIpTypeException();
        }
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
        if (!filter_var($address, FILTER_VALIDATE_IP)) {
            throw new InvalidIpAddressException();
        }
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
