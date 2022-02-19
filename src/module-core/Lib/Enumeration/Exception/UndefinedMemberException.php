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
 * The requested member was not found.
 */
final class UndefinedMemberException extends AbstractUndefinedMemberException {
	/**
	 * Construct a new undefined member exception.
	 *
	 * @param string $className The name of the class from which the member was requested.
	 * @param string $property The name of the property used to search for the member.
	 * @param mixed $value The value of the property used to search for the member.
	 * @param Exception|null $cause The cause, if available.
	 */
	public function __construct(
		$className,
		$property,
		$value,
		Exception $cause = null
	) {
		parent::__construct(
			sprintf(
				'No member with %s equal to %s defined in class %s.',
				$property,
				var_export($value, true),
				var_export($className, true)
			),
			$className,
			$property,
			$value,
			$cause
		);
	}
}
