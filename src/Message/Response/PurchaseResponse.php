<?php

namespace Omnipay\Nocks\Message\Response;

class PurchaseResponse extends FetchTransactionResponse
{
	/**
	 * {@inheritdoc}
	 */
	public function isRedirect()
	{
		// On a successful call it's always a redirect
		return parent::isSuccessful();
	}

	/**
	 * When you do a `purchase` the request is never successful because
	 * you need to redirect off-site to complete the purchase.
	 *
	 * {@inheritdoc}
	 */
	public function isSuccessful()
	{
		return false;
	}
}
