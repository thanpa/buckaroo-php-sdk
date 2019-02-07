<?php
namespace Buckaroo\Transaction;

/**
 * This class holds information about the channel error of a transaction.
 */
class RequestError
{
    /**
     * @var string
     */
    private $service = '';

    /**
     * @var string
     */
    private $action = '';

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $error = '';

    /**
     * @var string
     */
    private $errorMessage = '';

    /**
     * @var string
     */
    private $group = '';

    /**
     * Service setter
     *
     * @param string $service
     * @return RequestError
     */
    public function setService(string $service): RequestError
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Service getter
     *
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * Action setter
     *
     * @param string $action
     * @return RequestError
     */
    public function setAction(string $action): RequestError
    {
        $this->action = $action;

        return $this;
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
     * Name setter
     *
     * @param string $name
     * @return RequestError
     */
    public function setName(string $name): RequestError
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
     * Error setter
     *
     * @param string $error
     * @return RequestError
     */
    public function setError(string $error): RequestError
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Error getter
     *
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * ErrorMessage setter
     *
     * @param string $errorMessage
     * @return RequestError
     */
    public function setErrorMessage(string $errorMessage): RequestError
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * ErrorMessage getter
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }


    /**
     * Group setter
     *
     * @param string $group
     * @return RequestError
     */
    public function setGroup(string $group): RequestError
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Group getter
     *
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }
}
