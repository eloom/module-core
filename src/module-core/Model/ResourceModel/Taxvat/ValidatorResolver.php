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

namespace Eloom\Core\Model\ResourceModel\Taxvat;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

class ValidatorResolver implements ValidatorResolverInterface {
	
	/**
	 * @var ScopeConfigInterface
	 * @since 100.1.0
	 */
	protected $scopeConfig;
	
	/**
	 * Available validators
	 * @var array
	 */
	private $validators = [];
	
	/**
	 * @var LoggerInterface
	 */
	private $logger;
	
	/**
	 * @var SessionManagerInterface
	 */
	private $session;
	
	/**
	 * @param ScopeConfigInterface $scopeConfig
	 * @param SessionManagerInterface $session
	 * @param array $validators
	 * @param LoggerInterface $logger
	 */
	public function __construct(ScopeConfigInterface $scopeConfig,
	                            SessionManagerInterface $session,
	                            array $validators,
	                            LoggerInterface $logger) {
		$this->scopeConfig = $scopeConfig;
		$this->session = $session;
		$this->validators = $validators;
		$this->logger = $logger;
	}
	
	public function getCurrentValidator() {
		$storeId = $this->session->getStoreId();
		$currency = $this->scopeConfig->getValue('currency/options/default', ScopeInterface::SCOPE_STORE, $storeId);
		
		if (in_array($currency, $this->validators)) {
			return $currency;
		} else {
			$this->logger->error('Default currency engine is not configured, fallback is not possible');
		}
		
		return null;
	}
}