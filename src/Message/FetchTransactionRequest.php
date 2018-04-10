<?php


namespace Omnipay\Nocks\Message;

/**
 * Nocks Fetch Transaction Request
 *
 * @method \Omnipay\Nocks\Message\FetchTransactionResponse send()
 */
class FetchTransactionRequest extends AbstractRequest
{
	public function getData()
	{
		$this->validate('accessToken', 'transactionId');

		$data = array();
		$data['id'] = $this->getTransactionId();

		return $data;
	}

	public function sendData($data)
	{
		$httpResponse = $this->sendRequest('GET', '/transaction/' . $data['id']);

		return $this->response = new FetchTransactionResponse($this, $httpResponse->json());
	}
}