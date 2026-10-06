<?php

namespace Webkul\ChatGPT\Model\Config\Source;

class ChatGPTModel implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'text-davinci-003', 'label' => __('GPT-3.5')],
            ['value' => 'gpt-4', 'label' => __('GPT-4')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return ['text-davinci-003' => __('GPT-3.5'), 'gpt-4' => __('GPT-4')];
    }
}
