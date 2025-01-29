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

namespace Eloom\Core\Model;

use Magento\Framework\Locale\ResolverInterface;
use Magento\Store\Model\StoreManagerInterface;

class DefaultConfigProvider {
	
	private $storeManager;
	
	private $localeResolver;
	
	public function __construct(StoreManagerInterface $storeManager,
	                            ResolverInterface $localeResolver) {
		$this->storeManager = $storeManager;
		$this->localeResolver = $localeResolver;
	}
	
	public function getConfig() {
		return [
			'store' => [
				'code' => $this->storeManager->getStore()->getCode()
			]
		];
	}
	
	private function getLanguage(): string {
		return $this->localeResolver->getLocale();
	}
}