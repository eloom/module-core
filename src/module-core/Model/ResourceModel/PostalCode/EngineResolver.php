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

namespace Eloom\Core\Model\ResourceModel\PostalCode;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Psr\Log\LoggerInterface;

class EngineResolver implements EngineResolverInterface {
	
	/**
	 * @var ScopeConfigInterface
	 * @since 100.1.0
	 */
	protected $scopeConfig;
	
	/**
	 * Path to catalog search engine
	 * @var string
	 * @since 100.1.0
	 */
	protected $path;
	
	/**
	 * Scope type
	 * @var string
	 * @since 100.1.0
	 */
	protected $scopeType;
	
	/**
	 * Scope code
	 * @var null|string
	 * @since 100.1.0
	 */
	protected $scopeCode;
	
	/**
	 * Available engines
	 * @var array
	 */
	private $engines = [];
	
	/**
	 * @var LoggerInterface
	 */
	private $logger;
	
	/**
	 * @var string
	 */
	private $defaultEngine;
	
	/**
	 * @param ScopeConfigInterface $scopeConfig
	 * @param array $engines
	 * @param LoggerInterface $logger
	 * @param string $path
	 * @param string $scopeType
	 * @param string|null $scopeCode
	 * @param string|null $defaultEngine
	 */
	public function __construct(ScopeConfigInterface $scopeConfig,
	                            array $engines,
	                            LoggerInterface $logger,
	                            $path,
	                            $scopeType,
	                            $scopeCode = null,
	                            $defaultEngine = null) {
		$this->scopeConfig = $scopeConfig;
		$this->path = $path;
		$this->scopeType = $scopeType;
		$this->scopeCode = $scopeCode;
		$this->engines = $engines;
		$this->logger = $logger;
		$this->defaultEngine = $defaultEngine;
	}
	
	public function getCurrentSearchEngine() {
		$engine = $this->scopeConfig->getValue($this->path, $this->scopeType, $this->scopeCode);

		if (in_array($engine, $this->engines)) {
			return $engine;
		} else {
			if ($this->defaultEngine && in_array($this->defaultEngine, $this->engines)) {
				$this->logger->error($engine . ' search engine doesn\'t exist. Falling back to ' . $this->defaultEngine);
			} else {
				$this->logger->error('Default search engine is not configured, fallback is not possible');
			}
			
			return $this->defaultEngine;
		}
	}
}