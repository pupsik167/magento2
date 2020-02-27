<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Transoft\Blog\Api\BlogRepositoryInterface;

/**
 * Delete post controller
 */
class Delete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Transoft_Blog::blog_manage_items';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var BlogRepositoryInterface $blogRepository
     */
    private $blogRepository;

    /**
     * @inheritDoc
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param BlogRepositoryInterface $blogRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BlogRepositoryInterface $blogRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->blogRepository = $blogRepository;
        return parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');

        if (is_numeric($id)) {
            try {
                $post = $this->blogRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError(__('There is no post with this id.'));
            }
        }

        if ($post !== null) {
            if (!$post->getBlogId()) {
                $this->messageManager->addError(__('Blog post no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/', ['_current' => true]);
            }

            try {
                $this->blogRepository->delete($post);
                $this->messageManager->addSuccess(__('Your post has been deleted!'));
            } catch (CouldNotDeleteException $e) {
                $this->messageManager->addError(__('Error while trying to delete post'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/', ['_current' => true]);
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/', ['_current' => true]);
    }
}
