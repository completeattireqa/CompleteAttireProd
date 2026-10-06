<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Gateway\Validator;

use Braintree\Result\Error;
use Braintree\Result\Successful;
use Magento\Payment\Gateway\Validator\AbstractValidator;
use Webkul\MpBraintree\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Validator\ResultInterfaceFactory;

class GeneralResponseValidator extends AbstractValidator
{
    /**
     * @var SubjectReader
     */
    protected $subjectReader;

    /**
     * Constructor
     *
     * @param ResultInterfaceFactory $resultFactory
     * @param SubjectReader $subjectReader
     */
    public function __construct(ResultInterfaceFactory $resultFactory, SubjectReader $subjectReader)
    {
        parent::__construct($resultFactory);
        $this->subjectReader = $subjectReader;
    }

    /**
     * validate response object from api
     *
     * @param array $subjectValidate
     * @return void
     */
    public function validate(array $subjectValidate)
    {
        /** @var Successful|Error $response */
        $response = $this->subjectReader->readResponseObject($subjectValidate);
    
        $isValid = true;
        $errorMessages = [];

        foreach ($this->getResValidators() as $validator) {
            $validationResult = $validator($response);

            if (!$validationResult[0]) {
                $isValid = $validationResult[0];
                $errorMessages = array_merge($errorMessages, $validationResult[1]);
            }
        }

        return $this->createResult($isValid, $errorMessages);
    }

    /**
     * @return array
     */
    protected function getResValidators()
    {
        return [
            function ($gatewayResponse) {

                return [
                    property_exists($gatewayResponse, 'success') && $gatewayResponse->success === true,
                    [__("there is some error in gateway transaction processing")]
                ];
            }
        ];
    }
}
