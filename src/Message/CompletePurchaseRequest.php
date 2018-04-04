<?php

namespace Omnipay\Nocks\Message;


use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Nocks Complete Purchase Request
 *
 * @method \Omnipay\Nocks\Message\CompletePurchaseResponse send()
 */
class CompletePurchaseRequest extends FetchTransactionRequest
{
	public function getData()
	{
		$this->validate('accessToken');

		$transactionReference = $this->getTransactionReference();

		if (!$transactionReference) {
			throw new InvalidRequestException("The transactionReference parameter is required");
		}

		$data = array();
		$data['id'] = $transactionReference;

		return $data;
	}

	public function sendData($data)
	{
		$httpResponse = $this->sendRequest('GET', '/transaction/' . $data['id']);

		return $this->response = new CompletePurchaseResponse($this, $httpResponse->json());
	}
}