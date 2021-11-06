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

namespace Eloom\Core\Lib\Enumeration\Exception;

use Exception;

/**
 * An abstract base class for implementing undefined member exceptions.
 */
abstract class AbstractUndefinedMemberException extends Exception implements
	UndefinedMemberExceptionInterface {
	private $className;
	private $property;
	private $value;

	/**
	 * Construct a new undefined member exception.
	 *
	 * @param string $message The exception message.
	 * @param string $className The name of the class from which the member was requested.
	 * @param string $property The name of the property used to search for the member.
	 * @param mixed $value The value of the property used to search for the member.
	 * @param Exception|null $cause The cause, if available.
	 */
	public function __construct(
		$message,
		$className,
		$property,
		$value,
		Exception $cause = null
	) {
		$this->className = $className;
		$this->property = $property;
		$this->value = $value;

		parent::__construct($message, 0, $cause);
	}

	/**
	 * Get the class name.
	 *
	 * @return string The class name.
	 */
	public function className() {
		return $this->className;
	}

	/**
	 * Get the property name.
	 *
	 * @return string The property name.
	 */
	public function property() {
		return $this->property;
	}

	/**
	 * Get the value of the property used to search for the member.
	 *
	 * @return mixed The value.
	 */
	public function value() {
		return $this->value;
	}
}
