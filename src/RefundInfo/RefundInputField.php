<?php
namespace Buckaroo\RefundInfo;

use Buckaroo\RefundInfo\ParameterDescription\ParameterDescription;

/**
 * This class holds information about one refund input field
 */
class RefundInputField
{
    /**
     * @var ParameterDescription
     */
    private $fieldDefinition;

    /**
     * @var string
     */
    private $currentValue;

    /**
     * @var bool
     */
    private $currentValueIncorrect;

    /**
     * @var bool
     */
    private $currentValueEditable;


    /**
     * FieldDefinition setter.
     *
     * @param ParameterDescription $fieldDefinition
     * @return RefundInputField
     */
    public function setFieldDefinition(ParameterDescription $fieldDefinition): RefundInputField
    {
        $this->fieldDefinition = $fieldDefinition;

        return $this;
    }

    /**
     * FieldDefinition getter.
     *
     * @return ParameterDescription
     */
    public function getFieldDefinition(): ParameterDescription
    {
        return $this->fieldDefinition;
    }

    /**
     * CurrentValue setter.
     *
     * @param string $currentValue
     * @return RefundInputField
     */
    public function setCurrentValue(string $currentValue): RefundInputField
    {
        $this->currentValue = $currentValue;

        return $this;
    }

    /**
     * CurrentValue getter.
     *
     * @return string
     */
    public function getCurrentValue(): string
    {
        return $this->currentValue;
    }

    /**
     * CurrentValueIncorrect setter.
     *
     * @param bool $currentValueIncorrect
     * @return RefundInputField
     */
    public function setCurrentValueIncorrect(bool $currentValueIncorrect): RefundInputField
    {
        $this->currentValueIncorrect = $currentValueIncorrect;

        return $this;
    }

    /**
     * CurrentValueIncorrect getter.
     *
     * @return bool
     */
    public function getCurrentValueIncorrect(): bool
    {
        return $this->currentValueIncorrect;
    }

    /**
     * CurrentValueEditable setter.
     *
     * @param bool $currentValueEditable
     * @return RefundInputField
     */
    public function setCurrentValueEditable(bool $currentValueEditable): RefundInputField
    {
        $this->currentValueEditable = $currentValueEditable;

        return $this;
    }

    /**
     * CurrentValueEditable getter.
     *
     * @return bool
     */
    public function getCurrentValueEditable(): bool
    {
        return $this->currentValueEditable;
    }
}
