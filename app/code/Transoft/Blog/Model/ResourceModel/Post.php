<?php
declare(strict_types=1);

namespace Transoft\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Post resource model class
 */
class Post extends AbstractDb
{
    const MAIN_TABLE = 'transoft_blog';

    /**
     * Post model constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('transoft_blog', 'blog_id');
    }
}
