<?php
declare(strict_types=1);
namespace Transoft\Blog\Controller\Blog;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 *
 * Index controller class
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
