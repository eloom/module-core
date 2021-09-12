<?php
/**
* 
* Core para Magento 2
* 
* @category     elOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2021 elOOm (https://eloom.tech)
* @version      1.0.1
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
			'storeCode' => $this->storeManager->getStore()->getCode(),
			'lang' => $this->getLanguage(),
		];
	}
	
	private function getLanguage(): string {
		return $this->localeResolver->getLocale();
	}
}