<?php

namespace Omnipay\Nocks\Message;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\AbstractResponse;

class FetchTransactionResponse extends AbstractResponse implements RedirectResponseInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function isRedirect()
	{
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRedirectUrl()
	{
		if ($this->isRedirect()) {
			return 'https://nocks.com/payment/url/' . $this->getTransactionReference();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRedirectMethod()
	{
		return 'GET';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRedirectData()
	{
		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isSuccessful()
	{
		return isset($this->data['status']) && $this->data['status'] >= 200 && $this->data['status'] < 300;
	}

	/**
	 * @return boolean
	 */
	public function isOpen()
	{
		return isset($this->data['data']['status']) && in_array($this->data['data']['status'], ['pending', 'open']);
	}

	/**
	 * @return boolean
	 */
	public function isCancelled()
	{
		return isset($this->data['data']['status']) && 'cancelled' === $this->data['data']['status'];
	}

	/**
	 * @return boolean
	 */
	public function isPaid()
	{
		return isset($this->data['data']['status']) && 'completed' === $this->data['data']['status'];
	}

	/**
	 * @return boolean
	 */
	public function isExpired()
	{
		return isset($this->data['data']['status']) && 'expired' === $this->data['data']['status'];
	}

	/**
	 * @return mixed
	 */
	public function getTransactionId() {
		if (isset($this->data['data']['uuid'])) {
			return $this->data['data']['uuid'];
		}
	}

	/**
	 * @return mixed
	 */
	public function getTransactionReference()
	{
		if (isset($this->data['data']['payments']['data'][0]['uuid'])) {
			return $this->data['data']['payments']['data'][0]['uuid'];
		}
	}

	/**
	 * @return mixed
	 */
	public function getMetadata()
	{
		if (isset($this->data['data']['metadata'])) {
			return $this->data['data']['metadata'];
		}
	}

	/**
	 * @return mixed
	 */
	public function getMessage()
	{
		if (isset($this->data['error'])) {
			return $this->data['error']['message'];
		}
	}
}
