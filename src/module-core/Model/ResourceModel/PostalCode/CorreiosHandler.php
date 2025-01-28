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

use Eloom\Core\Lib\Correios\AtendeCliente;
use Eloom\Core\Lib\Correios\ConsultaCEP;
use Magento\Directory\Model\RegionFactory;

class CorreiosHandler implements EngineHandlerInterface {
	
	private $regionFactory;
	
	public function __construct(RegionFactory $regionFactory) {
		$this->regionFactory = $regionFactory;
	}
	
	/**
	 * @inheritDoc
	 */
	public function query(string $postalcode): array {
		$address = [];
		$client = new AtendeCliente();
		$consultaCEP = new ConsultaCEP(preg_replace('/\D/', '', $postalcode));
		
		try {
			$content = $client->consultaCEP($consultaCEP);
			
			if (isset($content->return)) {
				$address = [
					'street' => $content->return->end,
					'city' => $content->return->cidade,
					'state' => $this->regionFactory->create()->loadByCode($content->return->uf, 'BR')->getRegionId(),
					'district' => $content->return->bairro
				];
			}
		} catch (\Exception $e) {
		}
		
		return $address;
	}
	
	public function isAvailable(): bool {
		return true;
	}
}