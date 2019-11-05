<?php

namespace Omnipay\Nocks\Message\Request;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Nocks\Message\Response\FetchTransactionResponse;

class FetchTransactionRequest extends AbstractNocksRequest
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

		return $data;
	}

	/**
	 * @param array $data
	 * @return ResponseInterface|FetchTransactionResponse
	 */
	public function sendData($data)
	{
		$response = $this->sendRequest('GET', '/transaction/' . $data['id']);

		return $this->response = new FetchTransactionResponse($this, $response);
	}
}
