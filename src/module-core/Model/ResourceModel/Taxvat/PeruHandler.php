<?php
/**
* 
* Core para Magento 2
* 
* @category     elOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2022 elOOm (https://eloom.tech)
* @version      2.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\Core\Model\ResourceModel\Taxvat;

use Eloom\Core\Exception\TaxvatException;

class PeruHandler implements ValidatorHandlerInterface {
	
	/**
	 * @inheritDoc
	 *
	 * DNI (Documento Nacional de Identidad): 8 numeric digits.
	 * Cédula de Extranjería (Foreigner Identification Card):  9 numeric digits.
	 * RUC: The Registro Único de Contribuyentes (Unique Tax Number): 11 numeric digits.
	 */
	public function validate(string $taxvat = null): bool {
		if (null == $taxvat || '' == $taxvat) {
			throw new TaxvatException('Taxvat is required');
		}
		$taxvat = preg_replace('/[^0-9]/is', '', $taxvat);
		$chars = preg_split('//', $taxvat, -1, PREG_SPLIT_NO_EMPTY);
		
		if (sizeof($chars) != 8 && sizeof($chars) != 9 && sizeof($chars) != 11) {
			throw new TaxvatException();
		}
		
		return true;
	}
	
	public function isAvailable(): bool {
		return true;
	}
}