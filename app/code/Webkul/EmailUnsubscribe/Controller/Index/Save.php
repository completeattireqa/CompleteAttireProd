<?php
/**
 * @category   Webkul
 * @package    Webkul_EmailUnsubscribe
 * @author     Webkul Software Private Limited
 * @copyright  Copyright (c)  Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */
namespace Webkul\EmailUnsubscribe\Controller\Index;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use Webkul\EmailUnsubscribe\Model\UnsubscribeSellerFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Save extends Action
{
    /**
     * object of unsubscribeseller model
     * @var UnsubscribeSeller
     */
    protected $unsubscribeSeller;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param Context                                          $context
     * @param UnsubscribeSeller                                $unsubscribeSeller;
     * @param \Magento\Framework\Stdlib\DateTime\DateTime      $date
     * @param \Psr\Log\LoggerInterface                         $logger
     */
    public function __construct(
        Context $context,
        UnsubscribeSellerFactory $unsubscribeSeller,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        TimezoneInterface $localeDate,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->unsubscribeSeller = $unsubscribeSeller;
        $this->date = $date;
        $this->localeDate = $localeDate;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Save action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $sellerId = '';
            $time = $this->localeDate->date()->format('Y-m-d H:i:s');
            $resultRedirect = $this->resultRedirectFactory->create();
            $data = $this->getRequest()->getParams();
            if ($data) {
                $data['reason'] = implode(',', $data['reason']);
                $model = $this->unsubscribeSeller->create();
                $data['updated_at'] = $time;
                $sellerId = $data['seller_id'];
                $id = $this->isExist($data);
                if ($id) {
                    $model->load($id);
                    $data['entity_id'] = $id;
                } else {
                    $data['created_at'] = $time;
                }
                $model->setData($data)->save();
                // $this->messageManager->addSuccess(__('Seller Unsubscribed successfully.'));
            }
            return $resultRedirect->setPath('*/*/unsubscribe', ['seller_id' => $sellerId]);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    public function isExist($data)
    {
        $id = 0;
        $coll = $this->unsubscribeSeller->create()->getCollection()
            ->addFieldToFilter(
                'seller_email',
                $data['seller_email']
            );
        if (count($coll)) {
            foreach ($coll as $c) {
                $id = $c->getId();
            }
        }
        return $id;
    }
}
