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

namespace Eloom\Core\Resources\Builder;

use Eloom\Core\Resources\Builder;

class License {

	public static function getActiveLicenseUrl(): string {
		return Builder::getService(Builder::getApiUrl(), 'active-license');
	}

	public static function getCheckLicenseUrl(): string {
		return Builder::getService(Builder::getApiUrl(), 'check-license');
	}
}