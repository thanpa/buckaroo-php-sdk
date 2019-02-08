<?php
namespace Buckaroo\Service;

/**
 * Every service class that implements this interface, must implement it's
 * methods
 */
interface ServiceInterface
{
    public function getAction(): string;
    public function setParameters(array $parameters): ServiceInterface;
    public function toArray(): array;
}
