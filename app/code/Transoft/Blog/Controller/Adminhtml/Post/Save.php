<?php
declare(strict_types=1);
namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Transoft\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * Class Save
 *
 * Save controller class
 */
class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Post';

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
                $image_url = isset($data['image_url']) ? $data['image_url'][0]['url'] : '';
                $data['image_url'] = $image_url;

                $post = $this->postCollectionFactory->create()
                    ->addFieldToFilter('blog_id', ['eq' => $id])->getFirstItem();

                $data = array_filter($data);

                $post->setData($data);
                $post->save();
                $this->messageManager->addSuccess(__('Successfully saved the item.'));
                $this->dataPersistor->set('formData', false);
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->dataPersistor->set('formData', $data);
                return $resultRedirect->setPath('*/*/newAction');
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
