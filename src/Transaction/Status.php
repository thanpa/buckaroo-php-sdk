<?php
namespace Buckaroo\Transaction;

use Buckaroo\Transaction\Status\Code;
use DateTime;

/**
 * This class holds information about the status of the transaction.
 */
class Status
{

    /**
     * @var Code
     */
    private $code;

    /**
     * @var Code
     */
    private $subcode;

    /**
     * @var DateTime
     */
    private $datetime;

    /**
     * Code setter
     *
     * @param Code $code
     * @return Status
     */
    public function setCode(Code $code): Status
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Code getter
     *
     * @return Code
     */
    public function getCode(): Code
    {
        return $this->code;
    }

    /**
     * Subcode setter
     *
     * @param Code $subcode
     * @return Status
     */
    public function setSubcode(Code $subcode): Status
    {
        $this->subcode = $subcode;

        return $this;
    }

    /**
     * Subcode getter
     *
     * @return Code
     */
    public function getSubcode(): Code
    {
        return $this->subcode;
    }

    /**
     * Datetime setter
     *
     * @param DateTime $datetime
     * @return Status
     */
    public function setDatetime(DateTime $datetime): Status
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Datetime getter
     *
     * @return DateTime
     */
    public function getDatetime(): DateTime
    {
        return $this->datetime;
    }
}
