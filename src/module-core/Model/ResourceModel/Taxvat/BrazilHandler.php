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

class BrazilHandler implements ValidatorHandlerInterface {
	
	/**
	 * @inheritDoc
	 */
	public function validate(string $taxvat = null): bool {
		if (null == $taxvat || '' == $taxvat) {
			throw new TaxvatException('Taxvat is required');
		}
		$taxvat = preg_replace('/[^0-9]/is', '', $taxvat);
		$chars = preg_split('//', $taxvat, -1, PREG_SPLIT_NO_EMPTY);
		
		if (sizeof($chars) != 11 && sizeof($chars) != 14) {
			throw new TaxvatException();
		}
		
		$valid = false;
		try {
			$valid = $this->isCPF($chars);
			if (!$valid) {
				$valid = $this->isCNPJ($chars);
			}
		} catch (\Exception $e) {
		}
		
		if (!$valid) {
			throw new TaxvatException();
		}
		
		return $valid;
	}
	
	public function isAvailable(): bool {
		return true;
	}
	
	private function isCNPJ($c) {
		$b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
		
		for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]) ;
		
		if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
			return false;
		}
		for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]) ;
		
		if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
			return false;
		}
		
		return true;
	}
	
	private function isCPF($c) {
		for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) ;
		
		if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
			return false;
		}
		
		for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) ;
		if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
			return false;
		}
		
		return true;
	}
}