<?php
declare(strict_types=1);

namespace Transoft\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Transoft\Blog\Api\Data\ModelInterface;

class Model extends AbstractDb
{
    protected $_idFieldName = 'blog_id';

    protected function _construct()
    {
        $this->_init('transoft_blog', ModelInterface::BLOG_ID);
    }
}
