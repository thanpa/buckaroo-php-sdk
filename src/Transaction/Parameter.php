<?php
namespace Buckaroo\Transaction;

/**
 * This class holds information about the custom parameter of the transaction.
 */
class Parameter
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * Name setter
     *
     * @param string $name
     * @return CustomParameter
     */
    public function setName(string $name): CustomParameter
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Name getter
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Value setter
     *
     * @param string $value
     * @return CustomParameter
     */
    public function setValue(string $value): CustomParameter
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Value getter
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
