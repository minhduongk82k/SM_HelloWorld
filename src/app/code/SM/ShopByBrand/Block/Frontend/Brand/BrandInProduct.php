<?php
namespace SM\ShopByBrand\Block\Frontend\Brand;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class BrandInProduct extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    private $productFactory;

    /**
     * @var \SM\ShopByBrand\Model\BrandFactory
     */
    private $brandFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface  $scopeConfig,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \SM\ShopByBrand\Model\BrandFactory $brandFactory,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->brandFactory = $brandFactory;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function showBrandByProductID()
    {
        $brandId = $this->getBrandIdByProduct();
        return $this->brandFactory->create()->load($brandId);
    }
    public function getBrandIdByProduct()
    {
        $id = $this->getRequest()->getParam('id');
        $product = $this->productFactory->create()->load($id);
        return $product->getBrand();
    }
}


