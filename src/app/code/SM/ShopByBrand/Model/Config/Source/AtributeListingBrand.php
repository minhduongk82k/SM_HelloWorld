<?php
namespace SM\ShopByBrand\Model\Config\Source;

class AtributeListingBrand extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var \SM\ShopByBrand\Model\ResourceModel\Brand\CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        \SM\ShopByBrand\Model\ResourceModel\Brand\CollectionFactory $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;

    }
    public function getAllOptions()
    {
        $values = $this->collectionFactory->create()->getData();
        $arrayUse = [];

        $arrayValue = [];
        foreach ($values as $key => $value) {
            $arrayValue['value'] = $value['brand_id'];
            $arrayValue['label'] = __($value['name']);
            array_push($arrayUse, $arrayValue);
        }

        return $arrayUse;
    }
}
