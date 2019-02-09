<?php
namespace Buckaroo\Service;

use ReflectionClass;
use Buckaroo\Validators\Validator;

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
     * Makes sure that the class is first declared by requiring the appropriate file
     * then it returns the class name from within the declared classes with Reflection.
     *
     * @return array
     */
    public static function getServiceClassName(string $name): string
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

        return self::getDeclaredServices()[$name];
    }

    /**
     * Returns an array with all available services.
     *
     * @return array
     */
    public static function getDeclaredServices(): array
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
