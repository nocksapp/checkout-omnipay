<?php

namespace Omnipay\Nocks;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Nocks\Message\Request\CompletePurchaseRequest;
use Omnipay\Nocks\Message\Request\FetchIssuersRequest;
use Omnipay\Nocks\Message\Request\FetchTransactionRequest;
use Omnipay\Nocks\Message\Request\PurchaseRequest;


/**
 * @method RequestInterface authorize( array $options = array() )
 * @method RequestInterface completeAuthorize( array $options = array() )
 * @method RequestInterface capture( array $options = array() )
 * @method RequestInterface refund( array $options = array() )
 * @method RequestInterface void( array $options = array() )
 * @method RequestInterface createCard( array $options = array() )
 * @method RequestInterface updateCard( array $options = array() )
 * @method RequestInterface deleteCard( array $options = array() )
 */
class Gateway extends AbstractGateway
{
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
	 * @return FetchIssuersRequest
	 */
	public function fetchIssuers(array $parameters = [])
	{
		/** @var FetchIssuersRequest $request */
		$request = $this->createRequest(FetchIssuersRequest::class, $parameters);
		return $request;
	}

	/**
	 * @param  array $parameters
	 * @return FetchTransactionRequest
	 */
	public function fetchTransaction(array $parameters = [])
	{
		/** @var FetchTransactionRequest $request */
		$request = $this->createRequest(FetchTransactionRequest::class, $parameters);
		return $request;
	}

	/**
	 * @param  array $parameters
	 * @return PurchaseRequest
	 */
	public function purchase(array $parameters = [])
	{
		/** @var PurchaseRequest $request */
		$request = $this->createRequest(PurchaseRequest::class, $parameters);
		return $request;
	}

	/**
	 * @param  array $parameters
	 * @return CompletePurchaseRequest
	 */
	public function completePurchase(array $parameters = [])
	{
		/** @var CompletePurchaseRequest $request */
		$request = $this->createRequest(CompletePurchaseRequest::class, $parameters);
		return $request;
	}
}