<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Buckaroo\Transaction\RequiredAction;

final class RequiredActionTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeRedirectUrlThrowsTypeError(): void
    {
        $requiredAction = new RequiredAction();
        $requiredAction->setRedirectUrl(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeRequestedInformationThrowsTypeError(): void
    {
        $requiredAction = new RequiredAction();
        $requiredAction->setRequestedInformation(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypePayRemainderDetailsThrowsTypeError(): void
    {
        $requiredAction = new RequiredAction();
        $requiredAction->setPayRemainderDetails(new \stdClass());
    }

    /**
     * @expectedException \TypeError
     */
    public function testSetInvalidTypeNameThrowsTypeError(): void
    {
        $requiredAction = new RequiredAction();
        $requiredAction->setName(new \stdClass());
    }

    /**
     * @expectedException Buckaroo\Exceptions\InvalidUrlException
     */
    public function testSetInvalidReturnUrlThrowsInvalidUrlException(): void
    {
        $requiredAction = new RequiredAction();
        $requiredAction->setRedirectUrl('invalidUrl');
    }
}

