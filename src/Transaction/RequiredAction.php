<?php
namespace Buckaroo\Transaction;

use Buckaroo\Exceptions\InvalidUrlException;
use Buckaroo\Transaction\RequiredAction\RequestedInformation;
use Buckaroo\Transaction\RequiredAction\PayRemainderDetails;

/**
 * This class holds information that the developer needs to determine what
 * to do after a successful call to the API. For instance if there is a
 * redirectUrl, the developer will need to redirect the user to that url.
 */
class RequiredAction
{
    /**
     * @var string
     */
    private $redirectUrl = '';

    /**
     * @var RequestedInformation
     */
    private $requestedInformation;

    /**
     * @var PayRemainderDetails
     */
    private $payRemainderDetails;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var int
     */
    private $typeDeprecated = 0;

    /**
     * RedirectUrl setter
     *
     * @param string $redirectUrl
     * @return RequiredAction
     */
    public function setRedirectUrl(?string $redirectUrl): RequiredAction
    {
        $this->validateUrl($redirectUrl);
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    /**
     * RedirectUrl getter
     *
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * RequestedInformation setter
     *
     * @param RequestedInformation $requestedInformation
     * @return RequiredAction
     */
    public function setRequestedInformation(?RequestedInformation $requestedInformation): RequiredAction
    {
        $this->requestedInformation = $requestedInformation;

        return $this;
    }


    /**
     * RequestedInformation getter
     *
     * @return string
     */
    public function getRequestedInformation(): ?RequestedInformation
    {
        return $this->requestedInformation;
    }

    /**
     * PayRemainderDetails setter
     *
     * @param PayRemainderDetails $payRemainderDetails
     * @return RequiredAction
     */
    public function setPayRemainderDetails(?PayRemainderDetails $payRemainderDetails): RequiredAction
    {
        $this->payRemainderDetails = $payRemainderDetails;

        return $this;
    }


    /**
     * PayRemainderDetails getter
     *
     * @return PayRemainderDetails
     */
    public function getPayRemainderDetails(): ?string
    {
        return $this->payRemainderDetails;
    }

    /**
     * Name setter
     *
     * @param string $name
     * @return RequiredAction
     */
    public function setName(?string $name): RequiredAction
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
     * TypeDeprecated setter
     *
     * @param int $typeDeprecated
     * @return RequiredAction
     */
    public function setTypeDeprecated(?int $typeDeprecated): RequiredAction
    {
        $this->typeDeprecated = $typeDeprecated;

        return $this;
    }

    /**
     * TypeDeprecated getter
     *
     * @return int
     */
    public function getTypeDeprecated(): int
    {
        return $this->typeDeprecated;
    }

    /**
     * Validates the url string.
     *
     * @return array
     */
    private function validateUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException();
        }
    }
}
