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

namespace Eloom\Core\Observer;

use Eloom\Core\Model\NotificationFeedFactory;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class PredispatchAdminActionControllerObserver implements ObserverInterface {

	/**
	 * @var NotificationFeedFactory
	 */
	private $feedFactory;

	/**
	 * @var ManagerInterface
	 */
	private $manager;

	/**
	 * @type Session
	 */
	protected $authSession;

	/**
	 * OnActionPredispatchObserver constructor.
	 * @param NotificationFeedFactory $feedFactory
	 * @param ManagerInterface $manager
	 * @param Session $authSession
	 */
	public function __construct(NotificationFeedFactory $feedFactory,
	                            ManagerInterface $manager,
	                            Session $authSession) {
		$this->feedFactory = $feedFactory;
		$this->manager = $manager;
		$this->authSession = $authSession;
	}

	/**
	 * {@inheritdoc}
	 */
	public function execute(EventObserver $observer) {
		if ($this->authSession->isLoggedIn()) {
			$feedModel = $this->feedFactory->create();
			$feedModel->checkUpdate();
		}
	}
}
