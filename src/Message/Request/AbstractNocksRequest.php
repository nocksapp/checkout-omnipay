<?php

namespace Omnipay\Nocks\Message\Request;

use Omnipay\Common\Message\AbstractRequest;

abstract class AbstractNocksRequest extends AbstractRequest
{
	protected $endpoint = 'https://api.nocks.com/api/v2';
	protected $sandboxEndpoint = 'https://sandbox.nocks.com/api/v2';

	public function getAccessToken()
	{
		return $this->getParameter('accessToken');
	}

	public function setAccessToken($value)
	{
		return $this->setParameter('accessToken', $value);
	}

	protected function sendRequest($method, $endpoint, array $data = null)
	{
		$response = $this->httpClient->request(
			$method,
			($this->getTestMode() ? $this->sandboxEndpoint : $this->endpoint) . $endpoint,
			[
				'Accept' => 'application/json',
				'Authorization' => 'Bearer ' . $this->getAccessToken(),
			],
			($data === null || $data === []) ? null : json_encode($data)
		);

		return json_decode($response->getBody(), true);
	}
}
