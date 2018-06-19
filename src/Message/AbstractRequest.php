<?php

namespace Omnipay\Nocks\Message;


use Guzzle\Common\Event;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
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

	protected function sendRequest($method, $endpoint, $data = null)
	{
		$this->httpClient->getEventDispatcher()->addListener('request.error', function (Event $event) {
			/**
			 * @var \Guzzle\Http\Message\Response $response
			 */
			$response = $event['response'];

			if ($response->isError()) {
				$event->stopPropagation();
			}
		});

		$httpRequest = $this->httpClient->createRequest(
			$method,
			($this->getTestMode() ? $this->sandboxEndpoint : $this->endpoint) . $endpoint,
			[
				'Authorization' => 'Bearer ' . $this->getAccessToken(),
			],
			json_encode($data)
		);

		return $httpRequest->send();
	}
}