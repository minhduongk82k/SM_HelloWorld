<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SM\ShopByBrand\Controller\Adminhtml\Brand;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;
    /**
     * @var \SM\ShopByBrand\Model\Brand\ImageUploader
     */
    public $imageUploader;


    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \SM\ShopByBrand\Model\Brand\ImageUploader $imageUploader

     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \SM\ShopByBrand\Model\Brand\ImageUploader $imageUploader,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (isset($data['image']) && is_array($data['image'])) {
                if (!empty($data['image']['delete'])) {
                    $data['image'] = null;
                } else {
                    if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                        $data['image'] = $data['image'][0]['name'];
                    } else {
                        unset($data['image']);
                    }
                }
            }
            $id = $this->getRequest()->getParam('brand_id');

            $model = $this->_objectManager->create(\SM\ShopByBrand\Model\Brand::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Brand no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }


//            $data = $this->imageUploader->saveFileToTmpDir('image');
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Brand.'));
                $this->dataPersistor->clear('SM_shopbybrand_brand');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['brand_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Brand.'));
            }

            $this->dataPersistor->set('SM_shopbybrand_brand', $data);
            return $resultRedirect->setPath('*/*/edit', ['brand_id' => $this->getRequest()->getParam('brand_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
