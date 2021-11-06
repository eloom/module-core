<?php
/**
* 
* Core para Magento 2
* 
* @category     elOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2021 elOOm (https://eloom.tech)
* @version      1.0.2
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\Core\Lib\Enumeration;

/**
 * The interface implemented by Java-style enumeration instances.
 *
 * @api
 */
interface MultitonInterface {
	/**
	 * Returns the string key of this member.
	 *
	 * @return string The associated string key of this member.
	 * @api
	 *
	 */
	public function key();

	/**
	 * Check if this member is in the specified list of members.
	 *
	 * @param MultitonInterface $a The first member to check.
	 * @param MultitonInterface $b The second member to check.
	 * @param MultitonInterface $c,... Additional members to check.
	 *
	 * @return bool True if this member is in the specified list of members.
	 * @api
	 *
	 */
	public function anyOf(MultitonInterface $a, MultitonInterface $b);

	/**
	 * Check if this member is in the specified list of members.
	 *
	 * @param array<MultitonInterface> $values An array of members to search.
	 *
	 * @return bool True if this member is in the specified list of members.
	 * @api
	 *
	 */
	public function anyOfArray(array $values);

	/**
	 * Returns a string representation of this member.
	 *
	 * @return string
	 * @api
	 *
	 * Unless overridden, this is simply the string key.
	 *
	 */
	public function __toString();
}
