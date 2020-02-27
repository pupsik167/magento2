<?php
declare(strict_types=1);

namespace Transoft\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Transoft\Blog\Api\Data\BlogInterface;

/**
 * Blog model class
 */
class Blog extends AbstractModel implements BlogInterface
{
    /**
     * Define blog resource model
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Blog::class);
    }

    /**
     * @inheritdoc
     */
    public function getBlogId()
    {
        return $this->getData(BlogInterface::BLOG_ID);
    }

    /**
     * @inheritdoc
     */
    public function setBlogId($id) : BlogInterface
    {
        return $this->setData(BlogInterface::BLOG_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getTheme() : string
    {
        return $this->getData(BlogInterface::THEME);
    }

    /**
     * @inheritdoc
     */
    public function setTheme($theme) : BlogInterface
    {
        return $this->setData(BlogInterface::THEME, $theme);
    }

    /**
     * @inheritdoc
     */
    public function getContent() : string
    {
        return $this->getData(BlogInterface::CONTENT);
    }

    /**
     * @inheritdoc
     */
    public function setContent($content) : BlogInterface
    {
        return $this->setData(BlogInterface::CONTENT, $content);
    }

    /**
     * @inheritdoc
     */
    public function getImagePath() : string
    {
        return $this->getData(BlogInterface::IMAGE_PATH);
    }

    /**
     * @inheritdoc
     */
    public function setImagePath($imagePath) : BlogInterface
    {
        return $this->setData(BlogInterface::IMAGE_PATH, $imagePath);
    }

    /**
     * @inheritdoc
     */
    public function getCreationTime() : string
    {
        return $this->getData(BlogInterface::CREATION_TIME);
    }

    /**
     * @inheritdoc
     */
    public function setCreationTime($creationTime) : BlogInterface
    {
        return $this->setData(BlogInterface::CREATION_TIME, $creationTime);
    }
}
