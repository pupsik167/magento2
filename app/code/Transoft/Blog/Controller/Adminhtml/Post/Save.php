<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Transoft\Blog\Api\BlogRepositoryInterface;
use Transoft\Blog\Api\Data\BlogInterface;
use Transoft\Blog\Model\Blog;
use Transoft\Blog\Model\BlogFactory;

/**
 * Save post controller
 */
class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Transoft_Blog::blog_manage_items';

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
     * @var BlogRepositoryInterface
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
            if (empty($data[BlogInterface::BLOG_ID])) {
                $data[BlogInterface::BLOG_ID] = null;
            }

            $post = $this->blogFactory->create(['data' => $data]);

            $id = $this->getRequest()->getParam('id');
            $imagePath = $data['image_path'][0]['url'] ?? '';
            $data['image_path'] = $imagePath;

            if ($id) {
                try {
                    $post = $this->blogRepository->getById($id);
                } catch (NoSuchEntityException $e) {
                    $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
                $post->addData($data);
            } else {
                $post = $this->blogFactory->create(['data' => $data]);
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
     * @return ResultInterface $resultRedirect
     */
    private function processBlockReturn($blog, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';
        $id = $blog->getBlogId();

        if ($redirect === 'continue' && $id !== 0) {
            $resultRedirect->setPath('*/*/', [BlogInterface::BLOG_ID => $id]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
