<?php
/**
* 
* Core para Magento 2
* 
* @category     elOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2021 elOOm (https://eloom.tech)
* @version      1.0.3
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\Core\Lib\Enumeration\Exception;

use Exception;

/**
 * The supplied member extends an already concrete base class.
 *
 * This exception exists to prevent otherwise valid inheritance structures
 * that are not valid in the context of enumerations.
 *
 * @api
 */
final class ExtendsConcreteException extends Exception {
	private $className;
	private $parentClass;

	/**
	 * Construct a new extends concrete exception.
	 *
	 * @param string $className The class of the supplied member.
	 * @param string $parentClass The concrete parent class name.
	 * @param Exception|null $cause The cause, if available.
	 */
	public function __construct(
		$className,
		$parentClass,
		Exception $cause = null
	) {
		$this->className = $className;
		$this->parentClass = $parentClass;

		parent::__construct(
			sprintf(
				"Class '%s' cannot extend concrete class '%s'.",
				$this->className(),
				$this->parentClass()
			),
			0,
			$cause
		);
	}

	/**
	 * Get the class name of the supplied member.
	 *
	 * @return string The class name.
	 */
	public function className() {
		return $this->className;
	}

	/**
	 * Get the parent class name.
	 *
	 * @return string The parent class name.
	 */
	public function parentClass() {
		return $this->parentClass;
	}
}
