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

namespace Eloom\Core\Model;

use Eloom\Core\Client\ClientFactory;
use Eloom\Core\Resources\Builder\License as LicenseBuilder;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ProductMetadata;
use Magento\Framework\HTTP\Adapter\CurlFactory;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Store\Model\StoreManagerInterface;

class License {

	const STORE = 'store';
	const DOMAIN = 'domain';
	const IP = 'ip';
	const EDITION = 'edition';
	const VERSION = 'version';

	private $moduleList;

	private $productMetadata;

	private $transferBuilder;

	private $clientFactory;

	private $storeManager;

	public function __construct(ClientFactory $clientFactory,
															TransferBuilder $transferBuilder,
															ModuleListInterface $moduleList,
															ProductMetadata $productMetadata,
															StoreManagerInterface $storeManager) {
		$this->clientFactory = $clientFactory;
		$this->transferBuilder = $transferBuilder;
		$this->moduleList = $moduleList;
		$this->productMetadata = $productMetadata;
		$this->storeManager = $storeManager;
	}

	public function activeLicense() {
		$request = $this->prepareData();

		$transfer = $this->transferBuilder
			->setMethod('POST')
			->setHeaders(['Content-Type' => 'application/json; charset=UTF-8', 'Accept' => 'application/json'])
			->setBody(json_encode($request, JSON_UNESCAPED_SLASHES))
			->setUri(LicenseBuilder::getActiveLicenseUrl())
			->build();

		$client = $this->clientFactory->create();
		$client->setHeaders($transfer->getHeaders());
		$client->post($transfer->getUri(), $transfer->getBody());
	}

	public function creckLicense() {
		$request = $this->prepareData();

		$transfer = $this->transferBuilder
			->setMethod('POST')
			->setHeaders(['Content-Type' => 'application/json; charset=UTF-8', 'Accept' => 'application/json'])
			->setBody(json_encode($request, JSON_UNESCAPED_SLASHES))
			->setUri(LicenseBuilder::getCheckLicenseUrl())
			->build();

		$client = $this->clientFactory->create();
		$client->setHeaders($transfer->getHeaders());
		$client->post($transfer->getUri(), $transfer->getBody());
	}

	private function prepareData() {
		return [self::STORE => $this->storeManager->getStore()->getWebsiteId(),
			self::DOMAIN => $this->storeManager->getStore()->getCurrentUrl(true),
			self::IP => $this->getIP(),
			self::EDITION => $this->productMetadata->getEdition(),
			self::VERSION => $this->productMetadata->getVersion()
		];
	}

	private function getIP() {
		$ra = ObjectManager::getInstance()->get(\Magento\Framework\HTTP\PhpEnvironment\RemoteAddress::class);

		return $ra->getRemoteAddress();
	}
}
