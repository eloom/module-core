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

interface EngineHandlerInterface {
	
	/**
	 * @param string $postalcode
	 * @return array
	 */
	public function query(string $postalcode): array;
	
	/**
	 * @return boolean
	 */
	public function isAvailable(): bool;
}