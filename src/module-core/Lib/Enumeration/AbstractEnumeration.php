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

use ReflectionClass;

/**
 * Abstract base class for C++ style enumerations.
 *
 * @api
 */
abstract class AbstractEnumeration extends AbstractValueMultiton implements
	EnumerationInterface {
	/**
	 * Initializes the members of this enumeration based upon its class
	 * constants.
	 *
	 * Each constant becomes a member with a string key equal to the constant's
	 * name, and a value equal to that of the constant's value.
	 */
	final protected static function initializeMembers() {
		$reflector = new ReflectionClass(get_called_class());

		foreach ($reflector->getReflectionConstants() as $constant) {
			if ($constant->isPublic()) {
				new static($constant->getName(), $constant->getValue());
			}
		}
	}
}
