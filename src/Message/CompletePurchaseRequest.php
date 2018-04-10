<?php

namespace Omnipay\Nocks\Message;

/**
 * Nocks Complete Purchase Request
 *
 * @method \Omnipay\Nocks\Message\CompletePurchaseResponse send()
 */
class CompletePurchaseRequest extends FetchTransactionRequest
{
	public function getData()
	{
		$this->validate('accessToken', 'transactionId');

		$data = [];
		$data['id'] = $this->getTransactionId();

		return $data;
	}

	public function sendData($data)
	{
		$httpResponse = $this->sendRequest('GET', '/transaction/' . $data['id']);

		return $this->response = new CompletePurchaseResponse($this, $httpResponse->json());
	}
}