<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Transoft\Blog\Api\ModelRepositoryInterface;
use Transoft\Blog\Model\Model;
use Transoft\Blog\Model\ModelFactory;
use Transoft\Blog\Model\ModelRepository;

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
     * @var ModelFactory
     */
    private $modelFactory;
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var ModelRepository
     */
    private $modelRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param ModelFactory $modelFactory
     * @param ModelRepositoryInterface $modelRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        DataPersistorInterface $dataPersistor,
        ModelFactory $modelFactory = null,
        ModelRepositoryInterface $modelRepository = null
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistor;
        $this->modelFactory = $modelFactory
            ?: ObjectManager::getInstance()->get(ModelFactory::class);
        $this->modelRepository = $modelRepository
            ?: ObjectManager::getInstance()->get(ModelRepositoryInterface::class);
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

            $model = $this->modelFactory->create();

            $id = $this->getRequest()->getParam('id');
            $image_url = $data['image_path'][0]['url'];
            $data['image_path'] = $image_url;

            if ($id) {
                try {
                    $model = $this->modelRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->modelRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the post.'));
                $this->dataPersistor->clear('transoft_blog');
                return $this->processBlockReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the post.'));
            }

            $this->dataPersistor->set('transoft_blog', $data);
            return $resultRedirect->setPath('*/*/edit', ['blog_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the block return
     *
     * @param Model $model
     * @param array $data
     * @param ResultInterface $resultRedirect
     * @return ResultInterface
     * @throws CouldNotSaveException
     */
    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['blog_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $duplicateModel = $this->modelFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $this->modelRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated post.'));
            $this->dataPersistor->set('transoft_blog', $data);
            $resultRedirect->setPath('*/*/edit', ['blog_id' => $id]);
        }
        return $resultRedirect;
    }
}
