<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Transoft\Blog\Api\BlogRepositoryInterface;
use Transoft\Blog\Model\Blog;
use Transoft\Blog\Model\BlogFactory;
use Transoft\Blog\Model\BlogRepository;

/**
 * Save post controller
 */
class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Transoft_Blog::blog_manage_posts';

    /**
     * @var PageFactory $resultPageFactory
     */
    private $resultPageFactory;

    /**
     * @var BlogFactory
     */
    private $blogFactory;
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var BlogRepository
     */
    private $blogRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param BlogFactory $blogFactory
     * @param BlogRepositoryInterface $blogRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        DataPersistorInterface $dataPersistor,
        BlogFactory $blogFactory,
        BlogRepositoryInterface $blogRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistor;
        $this->blogFactory = $blogFactory;
        $this->blogRepository = $blogRepository;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            if (empty($data['blog_id'])) {
                $data['blog_id'] = null;
            }

            $post = $this->blogFactory->create();

            $id = $this->getRequest()->getParam('id');
            $image_url = $data['image_path'][0]['url'] ?? '';
            $data['image_path'] = $image_url;

            if ($id) {
                try {
                    $post = $this->blogRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            try {
                $this->blogRepository->save($post);
                $this->messageManager->addSuccessMessage(__('You saved the post.'));
                $this->dataPersistor->clear('transoft_blog');
                return $this->processBlockReturn($post, $data, $resultRedirect);
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

            $this->dataPersistor->set('transoft_blog', $data);
            return $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the block return
     *
     * @param Blog $blog
     * @param array $data
     * @param ResultInterface $resultRedirect
     * @return ResultInterface
     * @throws CouldNotSaveException
     */
    private function processBlockReturn($blog, $data, $resultRedirect) : ResultInterface
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['blog_id' => $blog->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $duplicateBlog = $this->blogFactory->create(['data' => $data]);
            $duplicateBlog->setBlogId(null);
            $duplicateBlog = $this->blogRepository->save($duplicateBlog);
            $id = $duplicateBlog->getBlogId();
            $this->messageManager->addSuccessMessage(__('You duplicated post.'));
            $this->dataPersistor->set('transoft_blog', $data);
            $resultRedirect->setPath('*/*/edit', ['blog_id' => $id]);
        }
        return $resultRedirect;
    }
}
