<?php

namespace Omnipay\Nocks\Message;


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