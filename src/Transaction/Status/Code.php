<?php
namespace Buckaroo\Transaction\Status;

class Code
{
    private $code = '';
    private $description = '';

    public function setCode(string $code): Code
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setDescription(string $description): Code
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
