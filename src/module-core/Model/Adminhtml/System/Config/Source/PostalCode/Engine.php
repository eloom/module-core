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

namespace Eloom\Core\Model\Adminhtml\System\Config\Source\PostalCode;

class Engine implements \Magento\Framework\Option\ArrayInterface {
	
	/**
	 * Engines list
	 *
	 * @var array
	 */
	private $engines;
	
	/**
	 * @param array $engines
	 */
	public function __construct(array $engines) {
		$this->engines = $engines;
	}
	
	/**
	 * @inheritdoc
	 */
	public function toOptionArray() {
		$options = [['value' => null, 'label' => __('--Please Select--')]];
		foreach ($this->engines as $key => $label) {
			$options[] = ['value' => $key, 'label' => $label];
		}
		return $options;
	}
}