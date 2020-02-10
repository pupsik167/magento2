<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Transoft\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * Post save controller
 */
class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Transoft_Blog::post';

    /**
     * @var PostCollectionFactory $postCollectionFactory
     */
    private $postCollectionFactory;

    /**
     * @var DataPersistorInterface $dataPersistor
     */
    private $dataPersistor;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param PostCollectionFactory $postCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        PostCollectionFactory $postCollectionFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->postCollectionFactory = $postCollectionFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $id = $data['blog_id'];
                $imageUrl = $data['image_path'][0]['url'] ?? '';
                $data['image_path'] = $imageUrl;

                $post = $this->postCollectionFactory->create()
                    ->addFieldToFilter('blog_id', ['eq' => $id])->getFirstItem();

                $data = array_filter($data);

                $post->setData($data);
                $post->save();
                $this->messageManager->addSuccess(__('Successfully saved the item.'));
                $this->dataPersistor->set('blog_data', false);
                $this->dataPersistor->clear('blog_data');
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->dataPersistor->set('formData', $data);
                return $resultRedirect->setPath('*/*/newAction');
            }
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @inheritdoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Transoft_Blog::blog_manage_items');
    }
}
