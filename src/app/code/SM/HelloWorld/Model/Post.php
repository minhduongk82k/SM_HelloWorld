<?php
namespace SM\HelloWorld\Model;

class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'sm_hello_world';

    protected $_cacheTag = 'sm_hello_world';

    protected $_eventPrefix = 'sm_hello_world';

    protected function _construct()
    {
        $this->_init('SM\HelloWorld\Model\ResourceModel\Post');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
