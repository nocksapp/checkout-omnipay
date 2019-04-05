<?php

namespace Omnipay\Nocks\Message;

/**
 * Nocks Purchase Request
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

	public function getData()
	{
		$this->validate('merchant', 'amount', 'currency', 'sourceCurrency', 'returnUrl', 'notifyUrl');

		$data                       = array();
		$data['merchant_profile']   = $this->getMerchant();
		$data['amount']             = ['amount' => $this->getAmount(), 'currency' => $this->getCurrency()];
		$data['source_currency']    = $this->getSourceCurrency();
		$data['redirect_url']       = $this->getReturnUrl();
		$data['callback_url']       = $this->getNotifyUrl();
		$data['metadata']           = $this->getMetadata();

		if ($method = $this->getPaymentMethod()) {
			$paymentMethodMetadata = [];
			if ($issuer = $this->getIssuer()) {
				$paymentMethodMetadata['issuer'] = $issuer;
			}

			$data['payment_method'] = [
				'method' => $method,
				'metadata' => $paymentMethodMetadata,
			];
		}

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