<?php

namespace SM\HelloWorld\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Custom fee config path
     */
    const CONFIG_CUSTOM_IS_ENABLED = 'paymentfee/config/enabled';
    const CONFIG_CUSTOM_FEE = 'paymentfee/config/fee';
    const CONFIG_FEE_LABEL = 'paymentfee/config/fee_name';
    const CONFIG_MINIMUM_ORDER_AMOUNT = 'paymentfee/config/fee_extra';

    /**
     * @return mixed
     */
    public function isModuleEnabled()
    {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_CUSTOM_IS_ENABLED, $storeScope);
    }

    /**
     * Get custom fee
     *
     * @return mixed
     */
    public function getCustomFee()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_CUSTOM_FEE, $storeScope);
    }

    /**
     * Get custom fee
     *
     * @return mixed
     */
    public function getFeeLabel()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_FEE_LABEL, $storeScope);
    }

    /**
     * @return mixed
     */
    public function getMinimumOrderAmount()
    {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::CONFIG_MINIMUM_ORDER_AMOUNT, $storeScope);
    }
}
