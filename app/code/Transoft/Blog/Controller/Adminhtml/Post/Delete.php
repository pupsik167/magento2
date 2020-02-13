<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\PageFactory;
use Transoft\Blog\Model\BlogRepository;

/**
 * Delete post controller
 */
class Delete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Transoft_Blog::blog_manage_posts';

    /**
     * Index resultPageFactory
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var BlogRepository $blogRepository
     */
    private $blogRepository;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param BlogRepository $blogRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BlogRepository $blogRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->blogRepository = $blogRepository;
        return parent::__construct($context);
    }

    /**
     * @inheritDoc
     *
     * @throws NotFoundException
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');

        try {
            $post = $this->blogRepository->getById($id);
        } catch (\Exception $e) {
            throw new NotFoundException(__($e->getMessage()));
        }

        if (!$post->getId()) {
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

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/', ['_current' => true]);
    }
}
