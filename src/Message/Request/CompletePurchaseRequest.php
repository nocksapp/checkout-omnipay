<?php

namespace Omnipay\Nocks\Message\Request;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Nocks\Message\Response\CompletePurchaseResponse;

class CompletePurchaseRequest extends FetchTransactionRequest
{
	/**
	 * @return array
	 * @throws InvalidRequestException
	 */
	public function getData()
	{
		$this->validate('accessToken', 'transactionId');

		$data = [];
		$data['id'] = $this->getTransactionId();

		if (empty($data['id'])) {
			throw new InvalidRequestException("The transactionId parameter is required");
		}

		return $data;
	}

	/**
	 * @param array $data
	 * @return CompletePurchaseResponse
	 */
	public function sendData($data)
	{
		$response = $this->sendRequest('GET', '/transaction/' . $data['id']);
		return $this->response = new CompletePurchaseResponse($this, $response);
	}
}
