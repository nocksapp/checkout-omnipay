<?php


namespace Omnipay\Nocks\Message;

/**
 * Fetch the ideal issuers
 */
class FetchIssuersRequest extends AbstractRequest
{
	public function getData()
	{
		return [];
	}

	public function sendData($data)
	{
		$httpResponse = $this->sendRequest('GET', '/settings');

		return $this->response = new FetchIssuersResponse($this, $httpResponse->json());
	}
}