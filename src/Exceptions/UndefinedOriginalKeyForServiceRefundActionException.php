<?php
namespace Buckaroo\Exceptions;

/**
 * This exception is thrown when the developer failed to provide
 * original transaction key for a refund action.
 */
class UndefinedOriginalKeyForServiceRefundActionException extends \Exception
{

}
