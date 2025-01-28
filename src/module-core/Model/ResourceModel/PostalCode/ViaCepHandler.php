<?php
/**
* 
* Core para Magento 2
* 
* @category     elOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2025 elOOm (https://eloom.com.br)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\Core\Model\ResourceModel\PostalCode;

use GuzzleHttp\Client;
use Magento\Directory\Model\RegionFactory;

class ViaCepHandler implements EngineHandlerInterface {
	
	private $regionFactory;
	
	public function __construct(RegionFactory $regionFactory) {
		$this->regionFactory = $regionFactory;
	}
	
	/**
	 * @inheritDoc
	 */
	public function query(string $postalcode): array {
		$address = [];
		$client = new Client();
		$response = $client->get("https://viacep.com.br/ws/{$postalcode}/json/unicode/", [
			'headers' => array_merge(array('Content-Type' => 'application/json')),
			'query' => null
		]);
		
		$content = json_decode($response->getBody()->getContents());
		if (isset($content->cep)) {
			$address = [
				'street' => $content->logradouro,
				'city' => $content->localidade,
				'state' => $this->regionFactory->create()->loadByCode($content->uf, 'BR')->getRegionId(),
				'district' => $content->bairro
			];
		}
		
		return $address;
	}
	
	public function isAvailable(): bool {
		return true;
	}
}