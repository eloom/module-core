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

namespace Eloom\Core\Lib\Correios;

use SoapClient;

class AtendeCliente extends SoapClient {
	
	const TIMEOUT = '30';
	
	private static $classmap = [
		'consultaCEP' => '\Eloom\Core\Lib\Correios\ConsultaCEP',
		'consultaCEPResponse' => '\Eloom\Core\Lib\Correios\ConsultaCEPResponse'];
	
	public function __construct(array $options = array(), $wsdl = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl') {
		foreach (self::$classmap as $key => $value) {
			if (!isset($options['classmap'][$key])) {
				$options['classmap'][$key] = $value;
			}
		}
		ini_set('default_socket_timeout', self::TIMEOUT);
		parent::__construct($wsdl, $options);
	}
	
	public function consultaCEP(ConsultaCEP $parameters) {
		return $this->__soapCall('consultaCEP', array($parameters));
	}
}
