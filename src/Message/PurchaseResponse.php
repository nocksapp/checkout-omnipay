<?php

namespace Omnipay\Nocks\Message;


class PurchaseResponse extends FetchTransactionResponse
{
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

	/**
	 * {@inheritdoc}
	 */
	public function isRedirect()
	{
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRedirectUrl()
	{
		return 'https://nocks.com/payment/url/' . $this->getPaymentReference();
	}
}