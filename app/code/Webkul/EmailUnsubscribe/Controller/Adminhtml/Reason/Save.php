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
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Save extends \Magento\Backend\App\Action
{
    /**
     * object of reason model
     * @var Reason
     */
    protected $reason;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @param Action\Context                                   $context
     * @param Reason                                           $reason;
     * @param \Magento\Framework\Stdlib\DateTime\DateTime      $date
     */
    public function __construct(
        Action\Context $context,
        Reason $reason,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        TimezoneInterface $localeDate
    ) {
        $this->reason = $reason;
        $this->date = $date;
        $this->localeDate = $localeDate;
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
     * Save action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $time = $this->localeDate->date()->format('Y-m-d H:i:s');
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams()['reason_form'];
        $id =  isset($data['entity_id']) ? $data['entity_id']: null;
        if ($data) {
            $model = $this->reason;
            $data['updated_at'] = $time;
            if ($id) {
                $model->load($id);
                $data['entity_id'] = $id;
                $msg = __('Reason updated successfully.');
            } else {
                $data['created_at'] = $time;
                $msg = __('Reason saved successfully.');
            }
            $model->setData($data)->save();
            $this->messageManager->addSuccess($msg);
        }
        return $resultRedirect->setPath('*/*/view');
    }
}
