<?php
/**
* 
* Core para Magento 2
* 
* @category     elOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2021 elOOm (https://eloom.tech)
* @version      1.0.2
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\Core\Block;

use Eloom\Core\Model\DefaultConfigProvider;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\JsonHexTag;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Template\Context;

class Template extends \Magento\Framework\View\Element\Template {
	
	/**
	 * @var DefaultConfigProvider
	 */
	protected $configProvider;
	
	/**
	 * @var SerializerInterface
	 */
	private $serializer;
	
	public function __construct(Context $context,
	                            DefaultConfigProvider $configProvider,
	                            SerializerInterface $serializerInterface = null,
	                            array $data = []) {
		$this->configProvider = $configProvider;
		$this->serializer = $serializerInterface ?: ObjectManager::getInstance()->get(JsonHexTag::class);
		
		parent::__construct($context, $data);
	}
	
	/**
	 * Retrieve configuration
	 *
	 * @return array
	 * @codeCoverageIgnore
	 */
	public function getConfig() {
		return $this->configProvider->getConfig();
	}
	
	/**
	 * Retrieve serialized config.
	 *
	 * @return bool|string
	 * @since 100.2.0
	 */
	public function getSerializedConfig() {
		return $this->serializer->serialize($this->getConfig());
	}
	
}