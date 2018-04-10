<?php

namespace Omnipay\Nocks\Message;


use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{

	/**
	 *
	 * @var \Omnipay\Nocks\Message\PurchaseRequest
	 */
	protected $request;

	public function setUp()
	{
		$this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
		$this->request->setAccessToken('abc');

		$this->request->initialize([
			'merchant' => '123',
			'amount' => '10.00',
			'currency' => 'EUR',
			'sourceCurrency' => 'NLG',
			'returnUrl' => 'http://www.example.com/return',
			'notifyUrl' => 'http://www.example.com/callback',
			'metadata' => ['order_id' => 1],
			'locale' => 'nl_NL',
		]);
	}

	public function testGetData()
	{
		$data = $this->request->getData();

		$this->assertSame('123', $data['merchant_profile']);
		$this->assertSame(['amount' => '10.00', 'currency' => 'EUR'], $data['amount']);
		$this->assertSame('NLG', $data['source_currency']);
		$this->assertSame('http://www.example.com/return', $data['redirect_url']);
		$this->assertSame('http://www.example.com/callback', $data['callback_url']);
		$this->assertSame(['order_id' => 1], $data['metadata']);
		$this->assertSame('nl_NL', $data['locale']);
		$this->assertCount(7, $data);
	}

	public function testSendSuccess()
	{
		$this->setMockHttpResponse('TransactionOpen.txt');
		$response = $this->request->send();

		$this->assertInstanceOf('Omnipay\Nocks\Message\PurchaseResponse', $response);
		$this->assertFalse($response->isSuccessful());
		$this->assertTrue($response->isRedirect());
		$this->assertSame('GET', $response->getRedirectMethod());
		$this->assertSame('https://nocks.com/payment/url/cf746fc8-c162-4b79-b981-6266f02f86c8', $response->getRedirectUrl());
		$this->assertNull($response->getRedirectData());
		$this->assertSame('cf746fc8-c162-4b79-b981-6266f02f86c8', $response->getTransactionReference());
		$this->assertTrue($response->isOpen());
		$this->assertFalse($response->isPaid());
		$this->assertNull($response->getMessage());
	}

	public function testSendFailure()
	{
		$this->setMockHttpResponse('TransactionFailure.txt');
		$response = $this->request->send();

		$this->assertInstanceOf('Omnipay\Nocks\Message\PurchaseResponse', $response);
		$this->assertFalse($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertNull($response->getTransactionReference());
		$this->assertNull($response->getRedirectUrl());
		$this->assertNull($response->getRedirectData());
		$this->assertSame('Object does not exist', $response->getMessage());
	}
}