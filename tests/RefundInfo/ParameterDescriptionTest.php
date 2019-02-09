<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\RefundInfo\ParameterDescription\ParameterDescription;

final class ParameterDescriptionTest extends TestCase
{
    /**
     * @expectedException Buckaroo\Exceptions\UnsupportedDataTypeException
     */
    public function testSetInvalidDataTypeThrowsUnsupportedDataTypeException(): void
    {
        $parameterDescription = new ParameterDescription();
        $parameterDescription->setDataType(100);
    }

    /**
     * @expectedException Buckaroo\Exceptions\UnsupportedListTypeException
     */
    public function testSetInvalidListThrowsUnsupportedListTypeException(): void
    {
        $parameterDescription = new ParameterDescription();
        $parameterDescription->setList(100);
    }
}

