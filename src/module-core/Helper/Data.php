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

namespace Eloom\Core\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

	protected Context $context;

	protected $scopeConfig;
	protected ObjectManager $objectManager;

	protected StoreManagerInterface $storeManager;

	protected $storeId;

	protected Http $request;

	protected Registry $registry;

	protected $inlineHtmlTags = [
		'b',
		'big',
		'i',
		'small',
		'tt',
		'abbr',
		'acronym',
		'cite',
		'code',
		'dfn',
		'em',
		'kbd',
		'strong',
		'samp',
		'var',
		'a',
		'bdo',
		'br',
		'img',
		'map',
		'object',
		'q',
		'span',
		'sub',
		'sup',
		'button',
		'input',
		'label',
		'select',
		'textarea',
		'\?',
	];

	public function __construct(Context               $context,
	                            StoreManagerInterface $storeManager,
	                            Http                  $request,
	                            Registry              $registry) {
		$this->context = $context;
		$this->storeManager = $storeManager;
		$this->request = $request;
		$this->registry = $registry;
		$this->objectManager = ObjectManager::getInstance();
		$this->storeId = $storeManager->getStore()->getId();

		parent::__construct($context);
	}

	public function getObjectManager() {
		return $this->objectManager;
	}

	public function getStoreManager() {
		return $this->storeManager;
	}

	public function getCurrentStoreId() {
		return $this->storeId;
	}

	public function getRequest() {
		return $this->request;
	}

	public function getCurrentUrl() {
		return $this->_urlBuilder->getCurrentUrl();
	}

	public function getCoreRegistry() {
		return $this->registry;
	}

	public function getConfig($path) {
		return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $this->storeId);
	}

	public function minifyHtml($content, $minifyJs = true) {
		$heredocs = [];
		$content = str_replace("//", "23abc22", (string)$content);
		$content = preg_replace_callback(
			'/<<<([A-z]+).*?\1;/ims',
			function ($match) use (&$heredocs) {
				$heredocs[] = $match[0];

				return '__MINIFIED_HEREDOC__' . (count($heredocs) - 1);
			},
			$content
		);
		$inlineTags = implode('|', $this->inlineHtmlTags);
		$content = preg_replace(
			'#(?<!]]>)\s+</#',
			'</',
			preg_replace(
				'#((?:<\?php\s+(?!echo|print|if|elseif|else)[^\?]*)\?>)\s+#',
				'$1 ',
				preg_replace(
					'#(?<!' . $inlineTags . ')\> \<#',
					'><',
					preg_replace(
						'#(?ix)(?>[^\S ]\s*|\s{2,})(?=(?:(?:[^<]++|<(?!/?(?:textarea|pre|script)\b))*+)'
						. '(?:<(?>textarea|pre|script)\b|\z))#',
						' ',
						preg_replace(
							'#(?<!:|\\\\|\'|")//(?!\s*\<\!\[)(?!\s*]]\>)[^\n\r]*#',
							'',
							preg_replace(
								'#(?<!:|\'|")//[^\n\r]*(\?\>)#',
								' $1',
								preg_replace(
									'#(?<!:)//[^\n\r]*(\<\?php)[^\n\r]*(\s\?\>)[^\n\r]*#',
									'',
									preg_replace(
										'# ? (</(' . $inlineTags . ')>)#',
										'$1 ', $content)
								)
							)
						)
					)
				)
			)
		);

		$content = preg_replace_callback(
			'/__MINIFIED_HEREDOC__(\d+)/ims',
			function ($match) use ($heredocs) {
				return $heredocs[(int)$match[1]];
			},
			$content
		);
		$content = str_replace("23abc22", "//", $content);
		if ($minifyJs) {
			$content = preg_replace_callback(
				'#<script(.*?)>(.*?)</script>#is', function ($matches) {
				if (strpos($matches[1], '-template') === false) {
					try {
						return '<script' . $matches[1] . '>' . \JShrink\Minifier::minify($matches[2]) . '</script>';
					} catch (\Exception  $e) {
						return $matches[0];
					}
				} else {
					return $matches[0];
				}
			},
				$content
			) ?: $content;
		}

		return rtrim($content);
	}
}
