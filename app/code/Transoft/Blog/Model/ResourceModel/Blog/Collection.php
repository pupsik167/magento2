<?php
declare(strict_types=1);

namespace Transoft\Blog\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Transoft\Blog\Model\Blog;
use Transoft\Blog\Model\ResourceModel\Blog as ResourceModelBlog;

/**
 * Blog collection class
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'blog_id';
    protected $_eventPrefix = 'transoft_blog_collection';
    protected $_eventObject = 'blog_collection';

    /**
     * Define blog resource model collection
     */
    protected function _construct()
    {
        $this->_init(Blog::class, ResourceModelBlog::class);
    }
}
