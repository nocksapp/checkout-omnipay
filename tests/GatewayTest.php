<?php

namespace Omnipay\Nocks;


use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
	/**
	 * @var Gateway
	 */
	protected $gateway;

	public function setUp()
	{
		parent::setUp();

		$this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
		$this->gateway->setAccessToken('abc');
	}

	public function testPurchase()
	{
		$request = $this->gateway->purchase([
			'merchant' => '123',
			'amount' => '10.00',
			'currency' => 'EUR',
			'sourceCurrency' => 'NLG',
			'paymentMethod' => 'ideal',
			'issuer' => 'ABNA',
			'returnUrl' => 'http://www.example.com/return',
			'notifyUrl' => 'http://www.example.com/callback',
			'metadata' => ['order_id' => 1],
			'locale' => 'nl_NL',
		]);

		$this->assertInstanceOf('Omnipay\Nocks\Message\Request\PurchaseRequest', $request);
		$this->assertSame('10.00', $request->getAmount());
		$this->assertSame('123', $request->getMerchant());
		$this->assertSame('EUR', $request->getCurrency());
		$this->assertSame('NLG', $request->getSourceCurrency());
		$this->assertSame('ideal', $request->getPaymentMethod());
		$this->assertSame('ABNA', $request->getIssuer());

		$this->assertSame(['order_id' => 1], $request->getMetadata());
		$this->assertSame('nl_NL', $request->getLocale());
		$this->assertSame('http://www.example.com/callback', $request->getNotifyUrl());
		$this->assertSame('http://www.example.com/return', $request->getReturnUrl());
	}

	public function testPurchaseReturn()
	{
		$request = $this->gateway->completePurchase(['transactionId' => '1']);

		$this->assertInstanceOf( 'Omnipay\Nocks\Message\Request\CompletePurchaseRequest', $request);
		$this->assertSame('1', $request->getTransactionId());
	}

	public function testFetchTransaction()
	{
		$request = $this->gateway->fetchTransaction(['transactionId' => '1']);

		$this->assertInstanceOf('Omnipay\Nocks\Message\Request\FetchTransactionRequest', $request);

		$data = $request->getData();

		$this->assertSame('1', $data['id']);
	}
}