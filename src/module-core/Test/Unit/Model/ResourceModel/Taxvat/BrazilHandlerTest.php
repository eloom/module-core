<?php
/**
* 
* Core para Magento 2
* 
* @category     elOOm
* @package      Modulo Core
* @copyright    Copyright (c) 2021 elOOm (https://eloom.tech)
* @version      1.0.0
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Dholi\Core\Test\Unit\Model\ResourceModel\Taxvat;

use Eloom\Core\Exception\TaxvatException;
use PHPUnit\Framework\TestCase;

class BrazilHandlerTest extends TestCase {
	
	protected function setUp(): void {
		$this->objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
		$this->handler = $this->objectManager->getObject('Eloom\Core\Model\ResourceModel\Taxvat\BrazilHandler');
	}
	
	public function testInvalid() {
		$result = $this->handler->validate('00000000031');
		$this->expectException(TaxvatException::class);
	}
	
	public function testValid() {
		$expectedResult = true;
		$result = $this->handler->validate('04007380660');
		
		$this->assertEquals($expectedResult, $result);
	}
}