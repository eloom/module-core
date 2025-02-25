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

namespace Eloom\Core\Model\ResourceModel\Taxvat;

use Eloom\Core\Exception\TaxvatException;

class DefaultHandler implements ValidatorHandlerInterface {
	
	/**
	 * @inheritDoc
	 */
	public function validate(string $taxvat = null): bool {
		if (null == $taxvat || '' == $taxvat) {
			throw new TaxvatException('Taxvat is required');
		}
		
		return true;
	}
	
	public function isAvailable(): bool {
		return true;
	}
}