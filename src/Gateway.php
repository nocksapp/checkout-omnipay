<?php


namespace Omnipay\Nocks;

use Omnipay\Common\AbstractGateway;


class Gateway extends AbstractGateway {

	/**
	 * Get gateway display name
	 *
	 * This can be used by carts to get the display name for each gateway.
	 */
	public function getName() {
		return 'Nocks';
	}

	/**
	 * @return array
	 */
	public function getDefaultParameters()
	{
		return [
			'accessToken'  => '',
			'testMode' => false,
		];
	}

	/**
	 * @return string
	 */
	public function getAccessToken()
	{
		return $this->getParameter('accessToken');
	}

	/**
	 * @param  string $value
	 * @return $this
	 */
	public function setAccessToken($value)
	{
		return $this->setParameter('accessToken', $value);
	}

	/**
	 * @param  array $parameters
	 * @return \Omnipay\Nocks\Message\FetchTransactionRequest
	 */
	public function fetchTransaction(array $parameters = array())
	{
		return $this->createRequest('\Omnipay\Nocks\Message\FetchTransactionRequest', $parameters);
	}

	/**
	 * @param  array $parameters
	 * @return \Omnipay\Nocks\Message\PurchaseRequest
	 */
	public function purchase(array $parameters = array())
	{
		return $this->createRequest('\Omnipay\Nocks\Message\PurchaseRequest', $parameters);
	}

	/**
	 * @param  array $parameters
	 *
	 * @return \Omnipay\Nocks\Message\CompletePurchaseRequest
	 */
	public function completePurchase(array $parameters = array())
	{
		return $this->createRequest( '\Omnipay\Nocks\Message\CompletePurchaseRequest', $parameters);
	}
}