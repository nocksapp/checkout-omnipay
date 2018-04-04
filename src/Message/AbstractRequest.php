<?php

namespace Omnipay\Nocks\Message;


abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
	protected $endpoint = 'https://api.nocks.com/api/v2';

	public function getAccessToken()
	{
		return $this->getParameter('accessToken');
	}

	public function setAccessToken($value)
	{
		return $this->setParameter('accessToken', $value);
	}

	protected function sendRequest($method, $endpoint, $data = null)
	{
		$httpRequest = $this->httpClient->createRequest(
			$method,
			$this->endpoint . $endpoint,
			[
				'Authorization' => 'Bearer ' . $this->getAccessToken(),
			],
			json_encode($data)
		);

		return $httpRequest->send();
	}
}