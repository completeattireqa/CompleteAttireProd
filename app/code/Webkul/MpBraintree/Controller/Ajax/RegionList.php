<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 *
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Controller\Ajax;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class RegionList extends Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Directory\Model\RegionFactory
     */
    protected $_regionFactory;

    /**
     * @param Context                         $context
     * @param PageFactory                     $resultPageFactory
     * @param \Magento\Customer\Model\Session $customerSession   customer session
     */
    public function __construct(
        Context $context,
        \Magento\Directory\Model\RegionFactory $regionFactory
    ) {
    
        $this->_regionFactory = $regionFactory;
        parent::__construct($context);
    }

    /**
     * ajax state return.
     *
     * @return json
     */
    public function execute()
    {
    
        $params = $this->_request->getParams();
        $regions = [];
        if (isset($params['country_code']) && $params['country_code']) {
            $regionCollection = $this->_regionFactory->
            create()->
            getCollection()
            ->addCountryFilter(
                $params['country_code']
            );

            $regions = $regionCollection->toOptionArray();
            if (!$regions) {
                $regions = [];
            }
        }
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($regions);
        return $resultJson;
    }
}
