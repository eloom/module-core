<?php
/**
* 
* Core para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2021 Ã©lOOm (https://eloom.tech)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\Core\Model\ResourceModel\Taxvat;

use Eloom\Core\Exception\TaxvatException;

interface ValidatorHandlerInterface {
	
	/**
	 * @param string $taxvat
	 * @return boolean
	 * @throws TaxvatException
	 */
	public function validate(string $taxvat): bool;
	
	/**
	 * @return boolean
	 */
	public function isAvailable(): bool;
}