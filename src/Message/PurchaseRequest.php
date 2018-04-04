<?php

namespace Omnipay\Nocks\Message;

/**
 * Nocks Purchase Request
 *
 * @method \Omnipay\Nocks\Message\PurchaseResponse send()
 */
class PurchaseRequest extends AbstractRequest
{
	public function getMerchant()
	{
		return $this->getParameter('merchant');
	}

	public function setMerchant($value)
	{
		return $this->setParameter('merchant', $value);
	}

	public function getSourceCurrency()
	{
		return $this->getParameter('sourceCurrency');
	}

	public function setSourceCurrency($value)
	{
		return $this->setParameter('sourceCurrency', $value);
	}

	public function getMetadata()
	{
		return $this->getParameter('metadata');
	}

	public function setMetadata($value)
	{
		return $this->setParameter('metadata', $value);
	}

	public function getLocale()
	{
		return $this->getParameter('locale');
	}

	public function setLocale($value)
	{
		return $this->setParameter('locale', $value);
	}

	public function setCallbackUrl($value)
	{
		return $this->setParameter('callbackUrl', $value);
	}

	public function getCallbackUrl()
	{
		return $this->getParameter('callbackUrl');
	}

	public function getData()
	{
		$this->validate('merchant', 'amount', 'currency', 'sourceCurrency', 'returnUrl', 'callbackUrl');

		$data                       = array();
		$data['merchant_profile']   = $this->getMerchant();
		$data['amount']             = ['amount' => $this->getAmount(), 'currency' => $this->getCurrency()];
		$data['source_currency']    = $this->getSourceCurrency();
		$data['redirect_url']       = $this->getReturnUrl();
		$data['callback_url']       = $this->getCallbackUrl();
		$data['metadata']           = $this->getMetadata();

		if ($locale = $this->getLocale()) {
			$data['locale'] = $locale;
		}

		return $data;
	}

	public function sendData($data)
	{
		$response = $this->sendRequest('POST', '/transaction', $data);

		return $this->response = new PurchaseResponse($this, $response->json());
	}
}