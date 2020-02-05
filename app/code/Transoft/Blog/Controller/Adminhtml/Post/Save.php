<?php
declare(strict_types=1);
namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Transoft\Blog\Model\PostFactory;

/**
 * Class Save
 *
 * Save controller class
 */
class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Post';

    protected $resultPageFactory;
    protected $postFactory;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param PostFactory $postFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PostFactory $postFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postFactory = $postFactory;
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
                $image_url = $data['image_url'][0]['url'];
                $data['image_url'] = $image_url;

                $post = $this->postFactory->create()->load($id);

                $data = array_filter($data, function ($value) {
                    return $value !== '';
                });

                $post->setData($data);
                $post->save();
                $this->messageManager->addSuccess(__('Successfully saved the item.'));
                $this->_objectManager->get(Session::class)->setFormData(false);
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get(Session::class)->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $post->getId()]);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
