<?php
declare(strict_types=1);

namespace Transoft\Blog\Controller\Blog;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Frontend index controller
 */
class View extends Action implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
