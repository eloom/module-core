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

namespace Eloom\Core\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

	public function __construct(\Magento\Framework\App\Helper\Context $context) {
		parent::__construct($context);
	}
}