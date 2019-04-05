<?php

namespace Omnipay\Nocks\Message;


use Omnipay\Tests\TestCase;
use Omnipay\Common\Issuer;


class FetchIssuersRequestTest extends TestCase
{
	/**
	 * @var \Omnipay\Nocks\Message\FetchIssuersRequest
	 */
	protected $request;

	public function setUp()
	{
		$this->request = new FetchIssuersRequest($this->getHttpClient(), $this->getHttpRequest());
	}

	public function testGetData()
	{
		$data = $this->request->getData();

		$this->assertCount(0, $data);
	}

	public function testSendSuccess()
	{
		$this->setMockHttpResponse('FetchIssuersSuccess.txt');
		$response = $this->request->send();

		$this->assertInstanceOf('Omnipay\Nocks\Message\FetchIssuersResponse', $response);
		$this->assertTrue($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertNull($response->getTransactionReference());

		$this->assertEquals([
			new Issuer('INGBNL2A', 'Issuer Simulation V3 - ING', 'ideal'),
			new Issuer('RABONL2U', 'Issuer Simulation V3 - RABO', 'ideal'),
		], $response->getIssuers());
	}

	public function testSendFailure()
	{
		$this->setMockHttpResponse('FetchIssuersFailure.txt');
		$response = $this->request->send();

		$this->assertInstanceOf('Omnipay\Nocks\Message\FetchIssuersResponse', $response);
		$this->assertFalse($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertNull($response->getTransactionReference());
		$this->assertEmpty($response->getIssuers());
	}

}
