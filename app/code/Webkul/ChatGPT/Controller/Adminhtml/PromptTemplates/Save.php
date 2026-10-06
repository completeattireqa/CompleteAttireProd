<?php declare(strict_types=1);
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_ChatGPT
 * @author    Webkul Software Private Limited
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\ChatGPT\Controller\Adminhtml\PromptTemplates;

use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var \Webkul\ChatGPT\Model\PromptTemplatesFactory
     */
    protected $promptTemplatesFactory;
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;
    /**
     *
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;
     /**
      * @var \Magento\Framework\Json\Helper\Data
      */
    protected $jsonHelper;
     /**
      * Locale Date/Timezone
      *
      * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
      */
    protected $_timezone;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Webkul\ChatGPT\Model\PromptTemplatesFactory $promptTemplatesFactory
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Webkul\ChatGPT\Model\PromptTemplatesFactory $promptTemplatesFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->promptTemplatesFactory = $promptTemplatesFactory;
        $this->_date = $date;
        $this->dataPersistor = $dataPersistor;
        $this->jsonHelper = $jsonHelper;
        $this->_timezone = $timezone;
        parent::__construct($context);
    }

    /**
     * Check for is allowed.
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_ChatGPT::prompt_templates_save');
    }

    /**
     * Delivery Orders page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        try {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $data = $this->getRequest()->getPostValue();            
            $message = '';
            if ($data) {
                $id = $this->getRequest()->getParam('entity_id');
                $model = $this->promptTemplatesFactory->create()->load($id);
                if (!$model->getId() && $id) {
                    $message = __('The row data no longer exists.');
                    $this->messageManager->addErrorMessage($message);
                    $response = [
                        'error' => true,
                        'redirect' => true,
                        'url' => $this->getUrl('chatgpt/prompttemplates/index'),
                        'status' => false,
                        'msg' => $message
                    ];
                    $this->getResponse()->setHeader('Content-type', 'application/json');
                    $this->getResponse()->setBody($this->jsonHelper
                            ->jsonEncode($response));
                }
                if (!$model->getId()) {
                    $model->setCreatedAt($this->_timezone->date()->format('Y-m-d H:i:s'));
                }
                try {
                    if (isset($data['section_global'])) {
                        $data['section_global'] = $this->jsonHelper->jsonEncode($data['section_global']);
                    }
                    if (isset($data['section_inputs'])) {
                        $data['section_inputs'] = $this->jsonHelper->jsonEncode($data['section_inputs']);
                    }
                    if (isset($id) && $id) {
                        $model = $this->promptTemplatesFactory->create()->load($id);
                        $data['updated_at'] = $this->_timezone->date()->format('Y-m-d H:i:s');
                        $model->setData($data)
                        ->save();
                        $message = __('You have updated the Prompt Template successfully.');
                        $this->messageManager->addSuccess($message);
                    } else {
                        $model = $this->promptTemplatesFactory->create();
                        $data['created_at'] = $this->_timezone->date()->format('Y-m-d H:i:s');
                        $data['updated_at'] = $this->_timezone->date()->format('Y-m-d H:i:s');
                        $model->addData($data);
                        $model->save();
                        $message = __('Prompt Template saved successfully.');
                        $this->messageManager->addSuccess($message);
                    }
                    $response = [
                        'status' => true,
                        'redirect' => true,
                        'url' => $this->getUrl('chatgpt/prompttemplates/index'),
                        'msg' => $message
                    ];
                    $this->getResponse()->setHeader('Content-type', 'application/json');
                    $this->getResponse()->setBody($this->jsonHelper
                            ->jsonEncode($response));
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                    $response = ['error' => true, 'status' => false, 'msg' => $e->getMessage()];
                    $this->getResponse()->setHeader('Content-type', 'application/json');
                    $this->getResponse()->setBody($this->jsonHelper
                            ->jsonEncode($response));
                } catch (\Exception $e) {
                    $this->messageManager->addExceptionMessage($e->getMessage());
                }
            } else {
                $response = ['error' => true, 'status' => false, 'msg' => __('Something went wrong in chatGPT.')];
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody($this->jsonHelper
                        ->jsonEncode($response));
            }
        } catch (\Exception $err) {
            $response = ['error' => true, 'status' => false, 'msg' => __($err->getMessage())];
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody($this->jsonHelper
                    ->jsonEncode($response));
        }
    }
}
