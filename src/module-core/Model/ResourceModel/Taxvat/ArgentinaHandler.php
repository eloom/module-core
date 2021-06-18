<?php
/**
* 
* Core para Magento 2
* 
* @category     elOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2021 elOOm (https://eloom.tech)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\Core\Model\ResourceModel\Taxvat;

use Eloom\Core\Exception\TaxvatException;

class ArgentinaHandler implements ValidatorHandlerInterface {
	
	/**
	 * @inheritDoc
	 *
	 * DNI (Documento Nacional de Identidad): 8 numeric digits.
	 * CUIT (Código Único de Identificación Tributaria): 11 numeric digits.
	 */
	public function validate(string $taxvat): bool {
		if ($taxvat == '') {
			throw new TaxvatException('Taxvat is required');
		}
		$taxvat = preg_replace('/[^0-9]/is', '', $taxvat);
		$chars = preg_split('//', $taxvat, -1, PREG_SPLIT_NO_EMPTY);
		
		if (sizeof($chars) != 8 && sizeof($chars) != 11) {
			throw new TaxvatException();
		}
		
		return true;
	}
	
	public function isAvailable(): bool {
		return true;
	}
}