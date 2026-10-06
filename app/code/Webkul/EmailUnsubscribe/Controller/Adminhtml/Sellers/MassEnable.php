<?php
/**
 * @category   Webkul
 * @package    Webkul_EmailUnsubscribe
 * @author     Webkul Software Private Limited
 * @copyright  Copyright (c)  Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */

namespace Webkul\EmailUnsubscribe\Controller\Adminhtml\Sellers;

use Magento\Backend\App\Action;
use Webkul\EmailUnsubscribe\Model\UnsubscribeSeller;
use Magento\Ui\Component\MassAction\Filter;

class MassEnable extends \Magento\Backend\App\Action
{
    /**
     * object of UnsubscribeSeller model
     * @var UnsubscribeSeller
     */
    protected $unsubscribeSeller;

    /**
     * filter object of Filter
     * @var Filter
     */
    protected $filter;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    /**
     * @var Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * @param Action\Context                                   $context
     * @param UnsubscribeSeller                                $unsubscribeSeller
     * @param Filter                                           $filter
     * @param \Magento\Framework\App\ResourceConnection        $resource
     */
    public function __construct(
        Action\Context $context,
        UnsubscribeSeller $unsubscribeSeller,
        Filter $filter,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->filter = $filter;
        $this->unsubscribeSeller = $unsubscribeSeller;
        $this->connection = $resource->getConnection();
        $this->resource = $resource;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_EmailUnsubscribe::sellers_view');
    }
    
    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $unsubscribeSellerModel = $this->unsubscribeSeller;
        $model = $this->filter;
        $collection = $model->getCollection($unsubscribeSellerModel->getCollection());
        
        $ids = [];
        foreach ($collection as $unsubscribeSeller) {
            $ids[] = $unsubscribeSeller->getId();
        }
        
        $update = ['status' => UnsubscribeSeller::STATUS_ENABLED];
        $where = ['entity_id IN (?)' => $ids];
        try {
            $this->connection->beginTransaction();
            $this->connection->update($this->resource->getTableName(UnsubscribeSeller::TABLE_NAME), $update, $where);
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
        }
        $this->messageManager->addSuccess(__('unsubscription(s) enabled successfully.'));
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
