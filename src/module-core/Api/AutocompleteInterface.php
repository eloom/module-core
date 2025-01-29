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

namespace Eloom\Core\Api;

/**
 * Interface for managing zipcode.
 * @api
 * @since 100.0.2
 */
interface AutocompleteInterface {

	/**
	 * Get address by zipCode.
	 *
	 * @param string $zipCode
	 * @return string
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function getAddressByZipCode($zipCode);
}