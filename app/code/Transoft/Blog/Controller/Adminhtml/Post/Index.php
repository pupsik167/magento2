<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Post index controller
 */
class Index extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Transoft_Blog::blog_manage_posts';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Posts')));

        return $this->resultPageFactory->create();
    }
}
