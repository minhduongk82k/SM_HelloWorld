<?php

namespace SM\ShopByBrand\Block\Frontend\Brand;


use Magento\Framework\App\ActionInterface;
class Showbrand extends \Magento\Framework\View\Element\Template
{


    /**
     * @var \SM\ShopByBrand\Model\BrandFactory
     */
    private $brandFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productcollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    private $productFactory;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    private $image;


    /**
     * @var \Magento\Catalog\Block\Product\AbstractProduct
     */
    private $abstractProduct;

    /**
     * @var \Magento\Framework\Url\Helper\Data
     */
    private $urlHelper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(

        \Magento\Framework\View\Element\Template\Context $context,
        \SM\ShopByBrand\Model\BrandFactory $brandFactory,

        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productcollectionFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Helper\Image $image,
        \Magento\Catalog\Block\Product\AbstractProduct $abstractProduct,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        array $data = []
    )
    {
        $this->brandFactory = $brandFactory;
        $this->productcollectionFactory = $productcollectionFactory;
        $this->productFactory = $productFactory;
        $this->image = $image;
        $this->abstractProduct = $abstractProduct;
        $this->urlHelper = $urlHelper;
        parent::__construct($context, $data);
    }

    public function showBrandDetail()
    {
        $id = $this->getRequest()->getParam('id');
        $brand = $this->brandFactory->create();
        if ($id != null) {
            $brand = $brand->load($id);
        } else {
            // redirect
        }
        return $brand;
    }

    public function getImage($product)
    {
        return $this->image->init($product, 'product_thumbnail_image')->getUrl();
    }

    public function getProductById($product_id)
    {
        return $this->productFactory->create()->load($product_id);
    }

    //Prepare for  button
    public function getProductCollection()
    {
        /** @var $collection \Magento\Catalog\Model\ResourceModel\Product\Collection */
        $id = $this->getRequest()->getParam('id');
        $collection = $this->productcollectionFactory->create()->addAttributeToFilter('brand', $id)->load();
        return $collection;
    }

    public function getAddToCartPostParams($product)
    {
        $url = $this->abstractProduct->getAddToCartUrl($product, ['_escape' => false]);
        return [
            'action' => $url,
            'data' => [
                'product' => (int) $product->getEntityId(),
                ActionInterface::PARAM_NAME_URL_ENCODED => $this->urlHelper->getEncodedUrl($url),
            ]
        ];
    }
}
