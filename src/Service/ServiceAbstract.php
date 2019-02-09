<?php
namespace Buckaroo\Service;

use ReflectionClass;
use Buckaroo\Validators\Validator;
use Buckaroo\Exceptions\UnsupportedServiceException;

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
     * @var Validator
     */
    private $validator;

    /**
     * Returns the class name of the provided service name.
     * Makes sure that the class is first declared by requiring the appropriate file
     * then it returns the class name from within the declared classes with Reflection.
     *
     * @param string $name
     * @return string
     */
    public static function getServiceClassName(string $name): string
    {
        self::requireService($name);
        $classes = get_declared_classes();
        foreach ($classes as $class) {
            $reflect = new ReflectionClass($class);
            $reflectedServiceName = strtolower(basename(str_replace('\\', '/', $class)));
            if ($reflect->implementsInterface('Buckaroo\Service\ServiceInterface') && $reflectedServiceName === $name) {
                return $class;
            }
        }
        throw new UnsupportedServiceException();
    }

    /**
     * Makes sure that the named service is required in order to be readable by the
     * reflection call for finding the class names of the declared services
     *
     * @param string $name
     * @return array
     */
    private static function requireService(string $name): void
    {
        $d = dir(__DIR__);
        while ($entry = $d->read()) {
            $ext = substr($entry, -4);
            if (!$ext === '.php') {
                continue;
            }
            $lowercaseFilename = strtolower(substr($entry, 0, -4));
            if ($lowercaseFilename !== $name) {
                continue;
            }
            $filepath = sprintf('%s/%s', __DIR__, $entry);
            if (file_exists($filepath)) {
                require_once $filepath;
                break;
            }
        }
        $d->close();
    }

    /**
     * Constructor
     *
     * @param ?string $action
     */
    public function __construct(?string $action)
    {
        $this->action = $action;
        $this->validator = new Validator();
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

    /**
     * Validator getter
     *
     * @return Validator
     */
    public function getValidator(): Validator
    {
        return $this->validator;
    }
}
