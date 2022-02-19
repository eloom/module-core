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

namespace Eloom\Core\Model\ResourceModel\Taxvat;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class ValidatorResolver implements ValidatorResolverInterface {
	
	/**
	 * Available validators
	 * @var array
	 */
	private $validators = [];
	
	/**
	 * @var LoggerInterface
	 */
	private $logger;

	protected $storeManager;

	public function __construct(StoreManagerInterface $storeManager,
	                            array $validators,
	                            LoggerInterface $logger) {
		$this->storeManager = $storeManager;
		$this->validators = $validators;
		$this->logger = $logger;
	}
	
	public function getCurrentValidator() {
		$store = $this->storeManager->getStore();
		$currency = $store->getCurrentCurrencyCode();

		if (in_array($currency, $this->validators)) {
			return $currency;
		} else {
			$this->logger->error('Default currency engine is not configured, fallback is not possible');
		}
		
		return null;
	}
}