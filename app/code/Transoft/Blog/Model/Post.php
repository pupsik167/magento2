<?php
declare(strict_types=1);

namespace Transoft\Blog\Model;

use Transoft\Blog\Model\ResourceModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Post model class
 */
class Post extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'transoft_blog_post';

    /**
     * @var string
     */
    protected $_cacheTag = 'transoft_blog';

    /**
     * @var string
     */
    protected $_eventPrefix = 'transoft_blog_post_collection';

    /**
     * Define post resource model
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Post::class);
    }

    /**
     * @inheritdoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
