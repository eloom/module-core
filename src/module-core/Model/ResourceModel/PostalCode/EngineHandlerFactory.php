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

use Magento\Framework\ObjectManagerInterface;

/**
 *
 * @api
 * @since 100.0.2
 */
class EngineHandlerFactory {
	/**
	 * Object Manager instance
	 *
	 * @var ObjectManagerInterface
	 */
	protected $objectManager = null;
	
	/**
	 * Instance name to create
	 *
	 * @var string
	 */
	protected $handlers = null;
	
	/**
	 * @var EngineResolverInterface
	 */
	private $engineResolver;
	
	/**
	 * Factory constructor
	 *
	 * @param ObjectManagerInterface $objectManager
	 * @param EngineResolverInterface $engineResolver
	 * @param string[] $handlers
	 */
	public function __construct(ObjectManagerInterface $objectManager,
	                            EngineResolverInterface $engineResolver,
	                            array $handlers = []) {
		
		$this->objectManager = $objectManager;
		$this->handlers = $handlers;
		$this->engineResolver = $engineResolver;
	}
	
	/**
	 * Create engine handler
	 *
	 * @param array $data
	 * @return EngineHandlerInterface
	 */
	public function create(array $data = []) {
		$currentHandler = $this->engineResolver->getCurrentSearchEngine();
		
		if (!isset($this->handlers[$currentHandler])) {
			throw new \LogicException('There is no such Postalcode handler: ' . $currentHandler);
		}
		$engine = $this->objectManager->create($this->handlers[$currentHandler], $data);
		
		if (!$engine instanceof EngineHandlerInterface) {
			throw new \InvalidArgumentException($currentHandler . ' engine handler doesn\'t implement ' . EngineHandlerInterface::class);
		}
		
		if ($engine && !$engine->isAvailable()) {
			throw new \LogicException('Postalcode handler is not available: ' . $currentHandler);
		}
		
		return $engine;
	}
}
