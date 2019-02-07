<?php
namespace Buckaroo\Transaction\RequiredAction;

/**
 * This class holds information that the developer needs to determine what
 * to do after a successful call to the API. For instance if there is a
 * redirectUrl, the developer will need to redirect the user to that url.
 */
class RequestedInformation
{
    const TYPE_STRING = 0;
    const TYPE_INTEGER = 1;
    const TYPE_DECIMAL = 2;
    const TYPE_DATE = 3;
    const TYPE_DATETIME = 4;
    const TYPE_BOOLEAN = 5;
    const TYPE_CARD_NUMBER = 6;
    const TYPE_EXPIRY_DATE = 7;
    const TYPE_CARD_START_DATE = 8;
    const VALID_TYPES =
        [
            self::TYPE_STRING,
            self::TYPE_INTEGER,
            self::TYPE_DECIMAL,
            self::TYPE_DATE,
            self::TYPE_DATETIME,
            self::TYPE_BOOLEAN,
            self::TYPE_CARD_NUMBER,
            self::TYPE_EXPIRY_DATE,
            self::TYPE_CARD_START_DATE
        ];

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var int
     */
    private $dataType;

    /**
     * @var int
     */
    private $maxLength;

    /**
     * @var bool
     */
    private $required;

    /**
     * @var string
     */
    private $description;

    /**
     * Name setter
     *
     * @param string $name
     * @return RequestedInformation
     */
    public function setName(string $name): RequestedInformation
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
     * DataType setter
     *
     * @param int $dataType
     * @return RequestedInformation
     */
    public function setDataType(int $dataType): RequestedInformation
    {
        $this->dataType = $dataType;

        return $this;
    }

    /**
     * DataType getter
     *
     * @return int
     */
    public function getDataType(): int
    {
        return $this->dataType;
    }

    /**
     * MaxLength setter
     *
     * @param int $maxLength
     * @return RequestedInformation
     */
    public function setMaxLength(int $maxLength): RequestedInformation
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * MaxLength getter
     *
     * @return int
     */
    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    /**
     * Required setter
     *
     * @param bool $required
     * @return RequestedInformation
     */
    public function setRequired(bool $required): RequestedInformation
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Required getter
     *
     * @return bool
     */
    public function getRequired(): bool
    {
        return $this->required;
    }

    /**
     * Description setter
     *
     * @param string $description
     * @return RequestedInformation
     */
    public function setDescription(string $description): RequestedInformation
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Name getter
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

}
