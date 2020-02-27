<?php
declare(strict_types=1);

namespace Transoft\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Transoft\Blog\Api\Data\BlogInterface;

/**
 * Blog resource model class
 */
class Blog extends AbstractDb
{
    const MAIN_TABLE = 'transoft_blog';
    protected $_idFieldName = 'blog_id';

    protected function _construct()
    {
        $this->_init('transoft_blog', BlogInterface::BLOG_ID);
    }
}
