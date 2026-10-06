<?php
/**
 * @category   Webkul
 * @package    Webkul_EmailUnsubscribe
 * @author     Webkul Software Private Limited
 * @copyright  Copyright (c)  Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */

namespace Webkul\EmailUnsubscribe\Controller\Adminhtml\Reason;

use Magento\Backend\App\Action;
use Webkul\EmailUnsubscribe\Model\Reason;
use Magento\Ui\Component\MassAction\Filter;

class MassEnable extends \Magento\Backend\App\Action
{
    /**
     * object of reason model
     * @var Reason
     */
    protected $reason;

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
     * @param Reason                                           $reason
     * @param Filter                                           $filter
     * @param \Magento\Framework\App\ResourceConnection        $resource
     */
    public function __construct(
        Action\Context $context,
        Reason $reason,
        Filter $filter,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->filter = $filter;
        $this->reason = $reason;
        $this->connection = $resource->getConnection();
        $this->resource = $resource;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_EmailUnsubscribe::reason_view');
    }
    
    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $reasonModel = $this->reason;
        $model = $this->filter;
        $collection = $model->getCollection($reasonModel->getCollection());
        
        $ids = [];
        foreach ($collection as $reason) {
            $ids[] = $reason->getId();
        }
        
        $update = ['status' => Reason::STATUS_ENABLED];
        $where = ['entity_id IN (?)' => $ids];
        try {
            $this->connection->beginTransaction();
            $this->connection->update($this->resource->getTableName(Reason::TABLE_NAME), $update, $where);
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
        }
        $this->messageManager->addSuccess(__('Reason(s) enabled successfully.'));
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/view');
    }
}
