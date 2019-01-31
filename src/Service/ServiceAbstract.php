<?php
namespace Buckaroo\Service;

abstract class ServiceAbstract
{
    private $action;

    public function __construct(string $action)
    {
        $this->action = $action;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setParameters(array $parameters): ServiceInterface
    {
        foreach ($parameters as $parameter) {
            if (property_exists($this, $parameter->Name)) {
                $this->{$parameter->Name} = $parameter->Value;
            }
        }
        return $this;
    }
}
