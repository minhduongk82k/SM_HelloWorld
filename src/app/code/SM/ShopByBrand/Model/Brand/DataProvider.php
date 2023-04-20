<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SM\ShopByBrand\Model\Brand;

use SM\ShopByBrand\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\ObjectManager;
use SM\ShopByBrand\Model\Brand\FileInfo;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;
    /**
     * @inheritDoc
     */
    protected $collection;
    private $fileInfo;
    protected $_storeManager;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $model = $this->convertValues($model);
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('brand');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('brand');
        }

        return $this->loadedData;
    }
    public function convertValues($banner)
    {
        $fileName = $banner->getImage();
        $image = [];
        if ($this->getFileInfo()->isExist($fileName)) {
            $stat = $this->getFileInfo()->getStat($fileName);
            $mime = $this->getFileInfo()->getMimeType($fileName);
            $image[0]['name'] = $fileName;
            $image[0]['url'] = $this->_storeManager->getStore()->getBaseUrl()."pub/media/catalog/tmp/category".$fileName;
            $image[0]['size'] = isset($stat) ? $stat['size'] : 0;
            $image[0]['type'] = $mime;
        }
        $banner->setImage($image);

        return $banner;
    }
    private function getFileInfo()
    {
        if ($this->fileInfo === null) {
            $this->fileInfo = ObjectManager::getInstance()->get(FileInfo::class);
        }
        return $this->fileInfo;
    }
}
