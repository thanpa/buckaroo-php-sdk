<?php
namespace Buckaroo\Validators;

use Buckaroo\Service\ServiceInterface;
use Buckaroo\Service\ServiceAbstract;
use Buckaroo\Transaction;
use Buckaroo\Service\Ideal;
use Buckaroo\Exceptions\InvalidCurrencyException;
use Buckaroo\Exceptions\UnsupportedServiceException;
use Buckaroo\Exceptions\UndefinedServiceException;
use Buckaroo\Exceptions\UndefinedIssuerForServicePayActionException;
use Buckaroo\Exceptions\UndefinedOriginalKeyForServiceRefundActionException;
use Buckaroo\Exceptions\UnsupportedIssuerException;

/**
 * Class for service validation
 */
class ServiceValidator
{
    /**
     * Validates the service name.
     *
     * @param ServiceInterface $service
     * @return void
     */
    public function validateName(ServiceInterface $service): void
    {
        if (empty($service->getName())) {
            throw new UndefinedServiceException();
        }
        $declaredServices = ServiceAbstract::getDeclaredServices();
        if (!in_array($service->getName(), array_keys($declaredServices))) {
            throw new UnsupportedServiceException();
        }
    }

    /**
     * Validates the ideal pay.
     *
     * @param ServiceInterface $service
     * @return void
     */
    public function validateIdealPay(ServiceInterface $service): void
    {
        if ($service->getName() === 'ideal' && $service->getAction() === 'Pay' && empty($service->getIssuer())) {
            throw new UndefinedIssuerForServicePayActionException();
        }
    }

    /**
     * Validates the ideal refund.
     *
     * @param ServiceInterface $service
     * @param Transaction      $trancaction
     * @return void
     */
    public function validateIdealRefund(ServiceInterface $service, Transaction $trancaction): void
    {
        if ($service->getName() === 'ideal'
            && $service->getAction() === 'Refund'
            && empty($trancaction->getOriginalTransactionKey())
        ) {
            throw new UndefinedOriginalKeyForServiceRefundActionException();
        }
    }

    /**
     * Validates the service issuer.
     *
     * @param string $issuer
     * @return void
     */
    public function validateIssuer(string $issuer): void
    {
        if (!in_array($issuer, Ideal::VALID_ISSUING_BANKS)) {
            throw new UnsupportedIssuerException();
        }
    }
}
