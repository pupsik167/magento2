<?php
declare(strict_types=1);
namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class NewAction
 *
 * New action controller class
 */
class NewAction extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Post';

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/edit');
    }
}
