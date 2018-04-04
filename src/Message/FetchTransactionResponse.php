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
			return $this->data['links']['paymentUrl'];
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
		return parent::isSuccessful();
	}

	/**
	 * @return boolean
	 */
	public function isOpen()
	{
		return isset($this->data['data']['status']) && 'open' === $this->data['data']['status'];
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
	public function getTransactionReference()
	{
		if ( isset( $this->data['data']['uuid'] ) ) {
			return $this->data['data']['uuid'];
		}
	}

	/**
	 * @return mixed
	 */
	public function getPaymentReference()
	{
		if ( isset( $this->data['data']['uuid']['payments']['data'][0]['uuid'] ) ) {
			return $this->data['data']['uuid']['payments']['data'][0]['uuid'];
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
}