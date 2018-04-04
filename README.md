Example usage:

```php
<?php

use Omnipay\Omnipay;

$accessToken = '';
$merchant = '';

$gateway = Omnipay::create('Nocks');
$gateway->setMerchant($merchant);
$gateway->setAccessToken($accessToken);

$response = $gateway->purchase([
	'amount' => 10.00,
	'currency' => 'NLG',
	'sourceCurrency' => 'NLG',
	'returnUrl' => 'http://example.com/return',
	'callbackUrl' => 'http://example.com/callback',
])->send();

if ($response->isRedirect()) {
	$response->redirect();
}

```