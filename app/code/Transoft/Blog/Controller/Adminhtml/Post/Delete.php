<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Transoft\Blog\Model\ModelRepository;

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
     * @var ModelRepository $modelRepository
     */
    private $modelRepository;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ModelRepository $modelRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ModelRepository $modelRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->modelRepository = $modelRepository;
        return parent::__construct($context);
    }

    /**
     * @inheritDoc
     *
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');

        $post = $this->modelRepository->getById($id);

        if (!$post->getBlogId()) {
            $this->messageManager->addError(__('Blog post no longer exists.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/', ['_current' => true]);
        }

        try {
            $this->modelRepository->delete($post);
            $this->messageManager->addSuccess(__('Your post has been deleted!'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete post'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/', ['_current' => true]);
    }
}
