<?php

namespace Omnipay\Nocks\Message;

use Omnipay\Nocks\Message\Request\CompletePurchaseRequest;
use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
	/**
	 * @var CompletePurchaseRequest
	 */
	protected $request;

	public function setUp()
	{
		$this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
		$this->request->setAccessToken('abc');
		$this->request->setTransactionId('1');
	}

	/**
	 * @expectedException \Omnipay\Common\Exception\InvalidRequestException
	 * @expectedExceptionMessage The transactionId parameter is required
	 */
	public function testGetDataWithoutIDParameter()
	{
		$this->request->setTransactionId(null);
		$data = $this->request->getData();
		$this->assertEmpty($data);
	}

	public function testGetData()
	{
		$data = $this->request->getData();
		$this->assertSame('1', $data['id']);
		$this->assertCount(1, $data);
	}

	public function testSendSuccess()
	{
		$this->setMockHttpResponse('TransactionPaid.txt');
		$response = $this->request->send();
		$this->assertInstanceOf('Omnipay\Nocks\Message\Response\CompletePurchaseResponse', $response);
		$this->assertTrue($response->isSuccessful());
		$this->assertFalse($response->isOpen());
		$this->assertTrue($response->isPaid());
		$this->assertFalse($response->isRedirect());
		$this->assertSame('1', $response->getTransactionId());
		$this->assertNull($response->getMessage());
	}

	public function testSendExpired()
	{
		$this->setMockHttpResponse('TransactionExpired.txt');
		$response = $this->request->send();
		$this->assertInstanceOf('Omnipay\Nocks\Message\Response\CompletePurchaseResponse', $response);
		$this->assertFalse($response->isSuccessful());
		$this->assertFalse($response->isPaid());
		$this->assertTrue($response->isExpired());
		$this->assertFalse($response->isRedirect());
		$this->assertSame('1', $response->getTransactionId());
		$this->assertNull($response->getMessage());
	}

	public function testSendFailure()
	{
		$this->setMockHttpResponse('TransactionFailure.txt');
		$response = $this->request->send();

		$this->assertInstanceOf('Omnipay\Nocks\Message\Response\CompletePurchaseResponse', $response);
		$this->assertFalse($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertNull($response->getTransactionReference());
		$this->assertSame('Object does not exist', $response->getMessage());
		$this->assertNull($response->getMetaData());
	}
}
