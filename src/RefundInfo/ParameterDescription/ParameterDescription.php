<?php
namespace Buckaroo\RefundInfo;

use Buckaroo\RefundInfo\ParameterDescription\ListItemDescription;
use Buckaroo\Validators\Validator;

/**
 * This class holds information about one refund input field
 */
class ParameterDescription
{

    const LIST_TYPE_NONE = 0;
    const LIST_TYPE_SINGLE = 1;
    const LIST_TYPE_MULTI = 2;
    const VALID_LIST_TYPES = [
        self::LIST_TYPE_NONE,
        self::LIST_TYPE_SINGLE,
        self::LIST_TYPE_MULTI
    ];
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $dataType;

    /**
     * @var int
     */
    private $list;

    /**
     * @var int
     */
    private $maxLength;

    /**
     * @var int
     */
    private $maxOccurs;

    /**
     * @var bool
     */
    private $required;

    /**
     * @var bool
     */
    private $global;

    /**
     * @var string
     */
    private $group;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $explanationHtml;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var string
     */
    private $inputPattern;

    /**
     * @var string
     */
    private $autoCompleteType;

    /**
     * @var array
     */
    private $listItemDescriptions;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * Constructor
     *
     * @param ?string $action
     */
    public function __construct()
    {
        $this->validator = new Validator();
    }

    /**
     * Name setter.
     *
     * @param string $name
     * @return ParameterDescription
     */
    public function setName(string $name): ParameterDescription
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Name getter.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * DataType setter.
     *
     * @param int $dataType
     * @return ParameterDescription
     */
    public function setDataType(int $dataType): ParameterDescription
    {
        $this->validator->validateDataType($dataType);

        $this->dataType = $dataType;

        return $this;
    }

    /**
     * DataType getter.
     *
     * @return int
     */
    public function getDataType(): int
    {
        return $this->dataType;
    }

    /**
     * List setter.
     *
     * @param int $list
     * @return ParameterDescription
     */
    public function setList(int $list): ParameterDescription
    {
        $this->validator->validateListTypes($list);

        $this->list = $list;

        return $this;
    }

    /**
     * List getter.
     *
     * @return int
     */
    public function getList(): int
    {
        return $this->list;
    }

    /**
     * MaxLength setter.
     *
     * @param int $maxLength
     * @return ParameterDescription
     */
    public function setMaxLength(int $maxLength): ParameterDescription
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * MaxLength getter.
     *
     * @return int
     */
    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    /**
     * ΜaxOccurs setter.
     *
     * @param int $maxOccurs
     * @return ParameterDescription
     */
    public function setΜaxOccurs(int $maxOccurs): ParameterDescription
    {
        $this->maxOccurs = $maxOccurs;

        return $this;
    }

    /**
     * ΜaxOccurs getter.
     *
     * @return int
     */
    public function getΜaxOccurs(): int
    {
        return $this->maxOccurs;
    }

    /**
     * Required setter.
     *
     * @param bool $required
     * @return ParameterDescription
     */
    public function setRequired(bool $required): ParameterDescription
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Required getter.
     *
     * @return bool
     */
    public function getRequired(): bool
    {
        return $this->required;
    }

    /**
     * Global setter.
     *
     * @param bool $global
     * @return ParameterDescription
     */
    public function setGlobal(bool $global): ParameterDescription
    {
        $this->global = $global;

        return $this;
    }

    /**
     * Global getter.
     *
     * @return bool
     */
    public function getGlobal(): bool
    {
        return $this->global;
    }

    /**
     * Description setter.
     *
     * @param string $description
     * @return ParameterDescription
     */
    public function setGlobal(string $description): ParameterDescription
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Description getter.
     *
     * @return string
     */
    public function getGlobal(): string
    {
        return $this->description;
    }

    /**
     * ExplanationHtml setter.
     *
     * @param string $explanationHtml
     * @return ParameterDescription
     */
    public function setExplanationHtml(string $explanationHtml): ParameterDescription
    {
        $this->explanationHtml = $explanationHtml;

        return $this;
    }

    /**
     * ExplanationHtml getter.
     *
     * @return string
     */
    public function getExplanationHtml(): string
    {
        return $this->explanationHtml;
    }

    /**
     * DisplayName setter.
     *
     * @param string $displayName
     * @return ParameterDescription
     */
    public function setDisplayName(string $displayName): ParameterDescription
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * ExplanationHtml getter.
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * InputPattern setter.
     *
     * @param string $inputPattern
     * @return ParameterDescription
     */
    public function setInputPattern(string $inputPattern): ParameterDescription
    {
        $this->inputPattern = $inputPattern;

        return $this;
    }

    /**
     * InputPattern getter.
     *
     * @return string
     */
    public function getInputPattern(): string
    {
        return $this->inputPattern;
    }

    /**
     * AutoCompleteType setter.
     *
     * @param string $autoCompleteType
     * @return ParameterDescription
     */
    public function setAutoCompleteType(string $autoCompleteType): ParameterDescription
    {
        $this->autoCompleteType = $autoCompleteType;

        return $this;
    }

    /**
     * AutoCompleteType getter.
     *
     * @return string
     */
    public function getAutoCompleteType(): string
    {
        return $this->autoCompleteType;
    }

    /**
     * ListItemDescriptions setter.
     *
     * @param array $listItemDescriptions
     * @return ParameterDescription
     */
    public function setListItemDescriptions(array $listItemDescriptions): ParameterDescription
    {
        foreach ($listItemDescriptions as $listItemDescription) {
            $listItemDescriptionObj = new ListItemDescription();
            $listItemDescriptionObj
                ->setDescription($listItemDescription->Description)
                ->setGroupName($listItemDescription->GroupName)
                ->setValue($listItemDescription->Value);
            $this->listItemDescription[] = $listItemDescriptionObj;
        }

        return $this;
    }

    /**
     * ListItemDescriptions getter.
     *
     * @return array
     */
    public function getListItemDescriptions(): array
    {
        return $this->listItemDescriptions;
    }
}
