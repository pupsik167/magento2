<?php
declare(strict_types=1);

namespace Transoft\Blog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Transoft\Blog\Model\Post;
use Transoft\Blog\Model\ResourceModel\Post as ResourceModelPost;

/**
 * Post resource model collection class
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'blog_id';
    protected $_eventPrefix = 'transoft_blog_post_collection';
    protected $_eventObject = 'post_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Post::class, ResourceModelPost::class);
    }
}
