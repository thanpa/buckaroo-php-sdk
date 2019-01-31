<?php
namespace Buckaroo\Service;

interface ServiceInterface
{
    public function getAction(): string;
    public function setParameters(array $parameters): ServiceInterface;
    public function toArray(): array;
}