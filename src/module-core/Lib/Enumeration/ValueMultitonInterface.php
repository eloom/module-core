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

namespace Eloom\Core\Lib\Enumeration;

/**
 * The interface implemented by Java-style enumeration instances with a value.
 *
 * @api
 */
interface ValueMultitonInterface extends MultitonInterface {
	/**
	 * Returns the value of this member.
	 *
	 * @return mixed The value of this member.
	 * @api
	 *
	 */
	public function value();
}
