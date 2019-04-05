# Omnipay: Nocks

**Nocks driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Nocks support for Omnipay.

## Installation

The Nocks Omnipay driver is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "nocksapp/omnipay-nocks": "^1.2.0"
    }
}
```

And run composer to update your dependencies.

## Basic Usage

```php
<?php

use Omnipay\Omnipay;

$accessToken = '';
$merchant = '';

$gateway = Omnipay::create('Nocks');
$gateway->setAccessToken($accessToken);
$gateway->setTestMode(true); // Use Nocks testmode/sandbox for testing

$response = $gateway->purchase([
	'merchant' => $merchant,
	'amount' => 10.00,
	'currency' => 'NLG',
	'sourceCurrency' => 'EUR',
	'returnUrl' => 'http://example.com/return',
	'callbackUrl' => 'http://example.com/callback',
	'paymentMethod' => 'ideal',
	'issuer' => 'ABNANL2A',
])->send();

if ($response->isRedirect()) {
	$response->redirect();
}

```

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.
