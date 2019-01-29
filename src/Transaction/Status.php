<?php
namespace Buckaroo\Transaction;

use Buckaroo\Transaction\Status\Code;
use DateTime;

class Status
{
    private $code;
    private $subcode;
    private $datetime = '';

    public function setCode(Code $code): Status
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): Code
    {
        return $this->code;
    }

    public function setSubcode(Code $subcode): Status
    {
        $this->subcode = $subcode;

        return $this;
    }

    public function getSubcode(): Code
    {
        return $this->subcode;
    }

    public function setDatetime(DateTime $datetime): Status
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getDatetime(): DateTime
    {
        return $this->datetime;
    }
}
