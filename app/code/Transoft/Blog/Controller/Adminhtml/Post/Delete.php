<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Transoft\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\View\Result\PageFactory;

/**
 * Delete post controller
 */
class Delete extends Action implements HttpGetActionInterface
{
    private $resultPageFactory;
    private $postCollectionFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param PostCollectionFactory $postCollectionFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PostCollectionFactory $postCollectionFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');

        $post = $this->postCollectionFactory->create()
            ->addFieldToFilter('blog_id', ['eq' => $id])->getFirstItem();

        if (!$id) {
            $this->messageManager->addError(__('Unable to process, there is no post with this ID.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/', ['_current' => true]);
        }

        try {
            $post->delete();
            $this->messageManager->addSuccess(__('Your post has been deleted!'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete post'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/', ['_current' => true]);
    }
}
