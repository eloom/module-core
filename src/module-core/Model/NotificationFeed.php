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

use Eloom\Core\Resources\Builder;
use Exception;
use Magento\AdminNotification\Model\Feed;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Config\ConfigOptionsListConstants;
use Magento\Framework\Escaper;
use SimpleXMLElement;

class NotificationFeed extends Feed {

	/**
	 * @var string
	 */
	protected $feedUrl;

	/**
	 * @var Escaper
	 */
	private $escaper;

	/**
	 * Check feed for modification
	 *
	 * @return $this
	 */
	public function checkUpdate() {
		if ($this->getFrequency() + $this->getLastUpdate() > time()) {
			return $this;
		}
		$feedData = [];
		$feedXml = $this->getFeedData();

		$installDate = strtotime($this->_deploymentConfig->get(ConfigOptionsListConstants::CONFIG_PATH_INSTALL_DATE));

		if ($feedXml && $feedXml->channel && $feedXml->channel->item) {
			foreach ($feedXml->channel->item as $item) {
				$itemPublicationDate = strtotime((string)$item->pubDate);
				if ($installDate <= $itemPublicationDate) {
					$feedData[] = [
						'severity' => 4,
						'date_added' => date('Y-m-d H:i:s', $itemPublicationDate),
						'title' => $this->escapeString($item->title),
						'description' => $this->escapeString($item->description),
						'url' => $this->escapeString($item->link),
					];
				}
			}

			if ($feedData) {
				$this->_inboxFactory->create()->parse(array_reverse($feedData));
			}
		}
		$this->setLastUpdate();

		return $this;
	}

	/**
	 * Retrieve feed data as XML element
	 *
	 * @return SimpleXMLElement
	 */
	public function getFeedData() {
		$curl = $this->curlFactory->create();
		$curl->setConfig(
			[
				'timeout' => 20,
				'useragent' => $this->productMetadata->getName()
					. '/' . $this->productMetadata->getVersion()
					. ' (' . $this->productMetadata->getEdition() . ')',
				'referer' => $this->urlBuilder->getUrl('*/*/*')
			]
		);
		$curl->write('GET', $this->getFeedUrl(), '1.0');
		$data = $curl->read();
		$data = preg_split('/^\r?$/m', $data, 2);
		$data = trim($data[1]);
		$curl->close();

		try {
			$xml = new SimpleXMLElement($data);
		} catch (Exception $e) {
			return false;
		}

		return $xml;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFeedUrl() {
		if ($this->feedUrl === null) {
			$this->feedUrl = Builder::getFeedUrl();
		}

		return $this->feedUrl;
	}

	/**
	 * Converts incoming data to string format and escapes special characters.
	 *
	 * @param \SimpleXMLElement $data
	 * @return string
	 */
	private function escapeString(\SimpleXMLElement $data) {
		$this->escaper = $this->escaper ?? ObjectManager::getInstance()->get(Escaper::class);
		$data2 = trim(preg_replace("/<.*?>/", "", (string)$data));

		return substr($this->escaper->escapeHtml($data2), 0, 255);
	}
}