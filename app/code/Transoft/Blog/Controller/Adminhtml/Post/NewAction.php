<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Post new action controller
 */
class NewAction extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Transoft_Blog::post';

    /**
     * @inheritdoc
     */
    public function execute()
    {
        return $this->_redirect('edit');
    }
}
