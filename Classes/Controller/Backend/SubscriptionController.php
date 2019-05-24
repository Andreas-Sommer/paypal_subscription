<?php
/**
 * Created by PhpStorm.
 * User: Andreas Sommer
 * Date: 21.05.2019
 * Time: 11:10
 */

namespace Belsignum\PaypalSubscription\Controller\Backend;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use Belsignum\PaypalSubscription\Domain\Model\Product\Product;
use Belsignum\PaypalSubscription\Utility\SubscriptionUtility;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;

class SubscriptionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

	/**
	 * @var \Belsignum\PaypalSubscription\Utility\SubscriptionUtility
	 */
	protected $subscriptionUtility =  null;

	/**
	 * @var \Extcode\CartProducts\Domain\Repository\Product\ProductRepository
	 */
	protected $productRepository = null;

	/**
	 * initialize action
	 * @return void
	 */
	public function initializeAction():void
	{
		$this->subscriptionUtility = new SubscriptionUtility($this->settings);
		$this->productRepository = $this->objectManager->get(ProductRepository::class);
	}

	/**
	 * product action
	 * @return void
	 */
	public function productAction():void
	{
		$pageId = (int)\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id');
		$products = $this->productRepository->findByIsSubscription(TRUE);
		$this->view->assignMultiple([
			'products' => $products,
			'returnUrl' => rawurlencode(BackendUtility::getModuleUrl('Cart_PaypalSubscriptionSubscriptions', ['id' => $pageId]))
		]);
	}

	/**
	 * update action
	 *
	 * @param \Belsignum\PaypalSubscription\Domain\Model\Product\Product $product
	 * @param string                                                     $operation
	 *
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
	 * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
	 * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
	 */
	public function updateAction(Product $product, string $operation):void
	{
		if($operation === 'createProduct')
		{
			$response = $this->subscriptionUtility->createCatalogProduct($product);
			$product->setPaypalProductId($response->id);
			$this->productRepository->update($product);
		}

		if($operation === 'createPlan')
		{
			$response = $this->subscriptionUtility->createBillingPlan($product);
			$product->setPaypalPlanId($response->id);
			$this->productRepository->update($product);
		}

		$this->redirect('product');

	}
}