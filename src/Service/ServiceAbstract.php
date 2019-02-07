<?php
namespace Buckaroo\Service;

/**
 * Abstract class for the services
 */
abstract class ServiceAbstract
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var int
     */
    private $version;

    /**
     * Constructor
     *
     * @param ?string $action
     */
    public function __construct(?string $action)
    {
        $this->action = $action;
    }

    /**
     * Action getter
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Version setter.
     *
     * @param int $version
     * @return ServiceInterface
     */
    public function setVersion(int $version): ServiceInterface
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Version getter
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Parameters of service setter
     *
     * @param array $parameters
     * @return ServiceInterface
     */
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
