## Buckaroo API client for PHP ##

Currently only accepting [iDEAL](https://dev.buckaroo.nl/PaymentMethods/Description/ideal#top)

## Requirements ##

To use the Buckaroo API client, the following things are required:

+ Get yourself a [Buckaroo account](https://www.buckaroo.nl/). Retrieve API keys.
+ PHP >= 7.2

The client uses curl, so make sure that your PHP is installed with the curl extension.

## Manual Installation ##

Download the code from the repository (git).

Create an autoload file and include it in your project.

## How to receive payments ##

To successfully receive a payment, these steps should be implemented:

1. Create a service that you need (for now only Ideal is available).

2. Create a transaction and add the service that you have created.

3. Send the customer to the provided redirect url.

4. Update the transaction status (Buckaroo will push information).

## Getting started ##

Initializing the Buckaroo API client, and setting your API key.

```php
$buckaroo = new \Buckaroo\Buckaroo();
$buckaroo->setApiKey("TEST_API_KEY");
```

Creating a new payment.

```php
$service = new \Buckaroo\Service\Ideal('Pay');
$service->setIssuer('ABNANL2A');
```
_You have to provide the type of the transaction (Pay or Refund)_

Then add the payment to a newly created transaction

```php
$transaction
    ->addService($service)
    ->setAmount(10.00)
    ->setInvoice('#CG0001');
```

Finally, execution of the transaction.

```php
$buckaroo->execute($transaction);
```
_After executing, the transaction key can be retrieved from the `$transaction->getKey()` method._

Now that the transaction is ready, redirect the customer to the payment provider.

```php
header("Location: " . $transaction->getRequiredAction()->getRedirectURL(), true, 303);
```
_This can be done with the 303 See Other http response code_

## Support ##
Contact: [www.thanpa.com](https://www.thanpa.com) — hello@thanpa.com — +30 2521105247