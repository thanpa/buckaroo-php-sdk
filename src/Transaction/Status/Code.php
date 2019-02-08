<?php
namespace Buckaroo\Transaction\Status;

/**
 * This class holds information about the status code of a transaction.
 * Each transaction has a code and a subcode which are both
 * instances of this class.
 */
class Code
{

    /**
     * @var string
     */
    private $code = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * Code setter
     *
     * @param string $code
     * @return Code
     */
    public function setCode(string $code): Code
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Code getter
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Description setter
     *
     * @param string $description
     * @return Code
     */
    public function setDescription(string $description): Code
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Description getter
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
