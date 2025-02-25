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

namespace Eloom\Core\Cron;

use Eloom\Core\Model\License;

class CheckLicense {

	private $license;

	public function __construct(License $license) {
		$this->license = $license;
	}

	public function execute() {
		$this->license->creckLicense();
	}
}