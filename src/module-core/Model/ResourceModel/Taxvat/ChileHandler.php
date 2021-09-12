<?php
/**
* 
* Core para Magento 2
* 
* @category     elOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2021 elOOm (https://eloom.tech)
* @version      1.0.1
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\Core\Model\ResourceModel\Taxvat;

use Eloom\Core\Exception\TaxvatException;

class ChileHandler implements ValidatorHandlerInterface {
	
	/**
	 * @inheritDoc
	 *
	 * RUT: The Rol Único Tributario (Unique Tax Number): 7-8 numeric digits.
	 */
	public function validate(string $taxvat = null): bool {
		if (null == $taxvat || '' == $taxvat) {
			throw new TaxvatException('Taxvat is required');
		}
		$taxvat = preg_replace('/[^0-9]/is', '', $taxvat);
		$chars = preg_split('//', $taxvat, -1, PREG_SPLIT_NO_EMPTY);
		
		if (sizeof($chars) != 7 && sizeof($chars) != 8) {
			throw new TaxvatException();
		}
		
		return true;
	}
	
	public function isAvailable(): bool {
		return true;
	}
}