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

namespace Eloom\Core\Model\ResourceModel\Taxvat;

use Magento\Framework\ObjectManagerInterface;

/**
 *
 * @api
 * @since 100.0.2
 */
class ValidatorHandlerFactory {
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
	 * @var ValidatorResolverInterface
	 */
	private $validatorResolver;
	
	/**
	 * Factory constructor
	 *
	 * @param ObjectManagerInterface $objectManager
	 * @param ValidatorResolverInterface $validatorResolver
	 * @param string[] $handlers
	 */
	public function __construct(ObjectManagerInterface $objectManager,
	                            ValidatorResolverInterface $validatorResolver,
	                            array $handlers = []) {
		
		$this->objectManager = $objectManager;
		$this->handlers = $handlers;
		$this->validatorResolver = $validatorResolver;
	}
	
	/**
	 * Create taxvat handler
	 *
	 * @param array $data
	 * @return ValidatorResolverInterface
	 */
	public function create(array $data = []) {
		$currentHandler = $this->validatorResolver->getCurrentValidator();
		
		if (!isset($this->handlers[$currentHandler])) {
			throw new \LogicException('There is no such Taxvat handler: ' . $currentHandler);
		}
		$engine = $this->objectManager->create($this->handlers[$currentHandler], $data);
		
		if (!$engine instanceof ValidatorHandlerInterface) {
			throw new \InvalidArgumentException($currentHandler . ' Taxvat handler doesn\'t implement ' . ValidatorHandlerInterface::class);
		}
		
		if ($engine && !$engine->isAvailable()) {
			throw new \LogicException('Taxvat handler is not available: ' . $currentHandler);
		}
		
		return $engine;
	}
}
