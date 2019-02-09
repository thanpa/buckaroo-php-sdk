<?php
namespace Buckaroo\RefundInfo\ParameterDescription\ListItemDescription;

/**
 * This class holds information about a list item description
 */
class ListItemDescription
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $groupName;

    /**
     * @var int
     */
    private $value;

    /**
     * Description setter.
     *
     * @param string $description
     * @return ListItemDescription
     */
    public function setDescription(string $description): ListItemDescription
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Description getter.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * GroupName setter.
     *
     * @param string $groupName
     * @return ListItemDescription
     */
    public function setGroupName(string $groupName): ListItemDescription
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * GroupName getter.
     *
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * Value setter.
     *
     * @param string $value
     * @return ListItemDescription
     */
    public function setValue(string $value): ListItemDescription
    {
        $this->value = $value;

        return $this;
    }

    /**
     * GroupName getter.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
