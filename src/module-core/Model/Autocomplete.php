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

namespace Eloom\Core\Model;

use Eloom\Core\Api\AutocompleteInterface;
use Eloom\Core\Model\ResourceModel\PostalCode\EngineHandlerFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;

class Autocomplete implements AutocompleteInterface {
	
	private $engineHandlerFactory;
	
	private $serializer;
	
	public function __construct(EngineHandlerFactory $engineHandlerFactory, Json $serializer = null) {
		$this->engineHandlerFactory = $engineHandlerFactory;
		$this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
	}
	
	/**
	 * @inheritDoc
	 */
	public function getAddressByZipCode($zipCode) {
		$factory = $this->engineHandlerFactory->create();
		$address = $factory->query($zipCode);
		
		return $this->serializer->serialize($address);
	}
}