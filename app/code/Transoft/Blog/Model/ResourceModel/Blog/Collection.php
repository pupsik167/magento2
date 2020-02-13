<?php
declare(strict_types=1);

namespace Transoft\Blog\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\Store;

/**
 * Blog collection class
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'blog_id';
    protected $_eventPrefix = 'transoft_blog_collection';
    protected $_eventObject = 'blog_collection';

    protected function _construct()
    {
        $this->_init('Transoft\Blog\Model\Blog', 'Transoft\Blog\Model\ResourceModel\Blog');
    }
}
