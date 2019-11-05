<?php

namespace Omnipay\Nocks\Message\Response;

use Omnipay\Common\Issuer;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\FetchIssuersResponseInterface;

class FetchIssuersResponse extends AbstractResponse implements FetchIssuersResponseInterface
{
	/**
	 * Is the response successful?
	 *
	 * @return boolean
	 */
	public function isSuccessful() {
		return isset($this->data['status']) && $this->data['status'] >= 200 && $this->data['status'] < 300;
	}

	/**
	 * Get the returned list of issuers.
	 *
	 * These represent banks which the user must choose between.
	 *
	 * @return Issuer[]
	 */
	public function getIssuers() {
		if ($this->isSuccessful()) {
			$issuers = [];
			foreach ($this->data['payment_methods']['ideal']['metadata']['issuers'] as $key => $value) {
				$issuers[] = new Issuer($key, $value, 'ideal');
			}

			return $issuers;
		}

		return [];
	}
}
