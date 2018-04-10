<?php

namespace Omnipay\Nocks\Message;


use Omnipay\Tests\TestCase;

class FetchTransactionRequestTest extends TestCase
{
	/**
	 * @var \Omnipay\Nocks\Message\FetchTransactionRequest
	 */
	protected $request;

	public function setUp()
	{
		$this->request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
		$this->request->setAccessToken('abc');
		$this->request->setTransactionId('1');
	}

	public function testGetData()
	{
		$data = $this->request->getData();

		$this->assertSame('1', $data['id']);
		$this->assertCount(1, $data);
	}

	public function testSendSuccess()
	{
		$this->setMockHttpResponse('TransactionOpen.txt');
		$response = $this->request->send();

		$this->assertInstanceOf('Omnipay\Nocks\Message\FetchTransactionResponse', $response);
		$this->assertTrue($response->isSuccessful());
		$this->assertFalse($response->isPaid());
		$this->assertFalse($response->isCancelled());
		$this->assertFalse($response->isRedirect());
		$this->assertSame('1', $response->getTransactionId());
		$this->assertNull($response->getMessage());
	}

	public function testSendExpired()
	{
		$this->setMockHttpResponse('TransactionExpired.txt');
		$response = $this->request->send();

		$this->assertInstanceOf('Omnipay\Nocks\Message\FetchTransactionResponse', $response);
		$this->assertTrue($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertSame('1', $response->getTransactionId());
		$this->assertTrue($response->isExpired());
		$this->assertNull($response->getMessage());
	}

	public function testSendFailure()
	{
		$this->setMockHttpResponse('TransactionFailure.txt');
		$response = $this->request->send();

		$this->assertInstanceOf('Omnipay\Nocks\Message\FetchTransactionResponse', $response);
		$this->assertFalse($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertNull($response->getTransactionId());
		$this->assertNull($response->getTransactionReference());
		$this->assertSame('Object does not exist', $response->getMessage());
	}
}