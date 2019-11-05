<?php
namespace Omnipay\Nocks\Message\Request;

use Omnipay\Nocks\Message\Response\FetchIssuersResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Fetch the ideal issuers
 */
class FetchIssuersRequest extends AbstractNocksRequest
{
	public function getData()
	{
		return [];
	}

	/**
	 * @param array $data
	 * @return ResponseInterface|FetchIssuersResponse
	 */
	public function sendData($data)
	{
		$response = $this->sendRequest('GET', '/settings');
		return $this->response = new FetchIssuersResponse($this, $response);
	}
}
