<?php
namespace Buckaroo\Transaction;

class RequiredAction
{
    private $redirectUrl = '';
    private $requestedInformation = '';
    private $payRemainderDetails = '';
    private $name = '';
    private $typeDeprecated = 0;

    public function setRedirectUrl(string $redirectUrl): RequiredAction
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    public function setRequestedInformation(?string $requestedInformation): RequiredAction
    {
        $this->requestedInformation = $requestedInformation;

        return $this;
    }

    public function getRequestedInformation(): ?string
    {
        return $this->requestedInformation;
    }


    public function setPayRemainderDetails(?string $payRemainderDetails): RequiredAction
    {
        $this->payRemainderDetails = $payRemainderDetails;

        return $this;
    }

    public function getPayRemainderDetails(): ?string
    {
        return $this->payRemainderDetails;
    }

    public function setName(string $name): RequiredAction
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setTypeDeprecated(int $typeDeprecated): RequiredAction
    {
        $this->typeDeprecated = $typeDeprecated;

        return $this;
    }

    public function getTypeDeprecated(): int
    {
        return $this->typeDeprecated;
    }
}
