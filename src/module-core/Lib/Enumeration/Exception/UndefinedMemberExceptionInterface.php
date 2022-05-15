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

namespace Eloom\Core\Lib\Enumeration\Exception;

/**
 * The interface implemented by exceptions that are thrown when an undefined
 * member is requested.
 *
 * @api
 */
interface UndefinedMemberExceptionInterface {
	/**
	 * Get the class name.
	 *
	 * @return string The class name.
	 * @api
	 *
	 */
	public function className();

	/**
	 * Get the property name.
	 *
	 * @return string The property name.
	 * @api
	 *
	 */
	public function property();

	/**
	 * Get the value of the property used to search for the member.
	 *
	 * @return mixed The value.
	 * @api
	 *
	 */
	public function value();
}
