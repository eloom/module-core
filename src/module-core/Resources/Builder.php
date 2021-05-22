<?php
/**
* 
* Core para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2021 Ã©lOOm (https://www.eloom.com.br)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Eloom\Core\Resources;

class Builder {

	const FILE = __DIR__ . '/resources.yaml';

	private static $instance;

	private static $data;

	private static $path;

	private static $services;

	public static function getInstance(): \Eloom\Core\Resources\Builder {
		if (!isset(self::$instance)) {
			self::$instance = new \Eloom\Core\Resources\Builder();
			self::$data = \Symfony\Component\Yaml\Yaml::parseFile(self::FILE);
			self::$path = self::$data['resources']['path'];
			self::$services = self::$data['resources']['services'];
		}

		return self::$instance;
	}

	public static function getUrl($resource): string {
		if (!isset(self::$instance)) {
			self::getInstance();
		}

		return sprintf("%s", self::$path[$resource]);
	}

	public static function getApiUrl(): string {
		if (!isset(self::$instance)) {
			self::getInstance();
		}

		return self::getUrl('api');
	}

	public static function getService($url, $service) {
		if (!isset(self::$instance)) {
			self::getInstance();
		}

		return sprintf("%s/%s", $url, self::$services[$service]);
	}

	public static function getFeedUrl(): string {
		if (!isset(self::$instance)) {
			self::getInstance();
		}

		return self::getUrl('feed');
	}
}