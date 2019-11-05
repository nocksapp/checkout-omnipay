<?php

namespace Omnipay\Nocks\Message\Response;

class CompletePurchaseResponse extends FetchTransactionResponse
{
	/**
	 * {@inheritdoc}
	 */
	public function isSuccessful()
	{
		return parent::isSuccessful() && $this->isPaid();
	}
}
