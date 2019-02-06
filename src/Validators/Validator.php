<?php
namespace Buckaroo\Validators;

use Buckaroo\Service\ServiceInterface;
use Buckaroo\Exceptions\InvalidUrlException;
use Buckaroo\Exceptions\UnsupportedServiceException;
use Buckaroo\Exceptions\UndefinedServiceException;
use ReflectionClass;

/**
 * Class for validation
 */
class Validator
{
    /**
     * @var Validator
     */
    private $currencyValidator;

    /**
     * Constructor
     *
     * @param ?string $action
     */
    public function __construct()
    {
        $this->currencyValidator = new CurrencyValidator();
    }

    /**
     * Validates the url string.
     *
     * @param string $url
     * @return void
     */
    public function validateUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException();
        }
    }

    /**
     * Validates the service.
     *
     * @param ServiceInterface $service
     * @return void
     */
    public function validateService(ServiceInterface $service): void
    {
        if (empty($service->getName())) {
            throw new UndefinedServiceException();
        }
        $declaredServices = $this->getDeclaredServices();
        if (!in_array($service->getName(), array_keys($declaredServices))) {
            throw new UnsupportedServiceException();
        }
    }

    /**
     * Returns an array with all declared services
     *
     * @return array
     */
    public function getDeclaredServices(): array
    {
        $classes = get_declared_classes();
        $declaredServices = [];
        foreach ($classes as $class) {
           $reflect = new ReflectionClass($class);
           if ($reflect->implementsInterface('Buckaroo\Service\ServiceInterface')) {
              $declaredServices[strtolower(basename(str_replace('\\', '/', $class)))] = $class;
           }
        }
        return $declaredServices;
    }

    /**
     * Validates the currency string.
     *
     * @param string $currency
     * @return void
     */
    public function validateCurrency(string $currency): void
    {
        $this->currencyValidator->validate($currency);
    }
}
