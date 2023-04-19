<?php
namespace SM\ShopByBrand\Model\ResourceModel\Brand;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'brand_id';
    protected $_eventPrefix = 'SM_shopbybrand_brand_collection';
    protected $_eventObject = 'brand_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('SM\ShopByBrand\Model\Brand', 'SM\ShopByBrand\Model\ResourceModel\Brand');
    }
}
