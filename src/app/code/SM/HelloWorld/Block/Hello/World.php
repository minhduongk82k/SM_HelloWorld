<?php
namespace SM\HelloWorld\Block\Hello;
class World extends \Magento\Framework\View\Element\Template
{
    protected $_postFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \SM\HelloWorld\Model\PostFactory $postFactory
    )
    {
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    public function sayHello()
    {
        return __('Table test CRUD');
    }

    public function getPostCollection(){
        $post = $this->_postFactory->create();
        return $post->getCollection();
    }
}
