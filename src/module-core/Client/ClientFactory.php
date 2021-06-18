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

namespace Eloom\Core\Client;

class ClientFactory {

	protected $objectManager = null;

	protected $instanceName = null;

	public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = \Magento\Framework\HTTP\Client\Curl::class) {
		$this->objectManager = $objectManager;
		$this->instanceName = $instanceName;
	}

	public function create(array $data = []) {
		return $this->objectManager->create($this->instanceName, $data);
	}
}
