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
    protected function _construct()
    {
        $this->_init(ResourceModel\Blog::class);
    }

    /**
     * @inheritdoc
     */
    public function getBlogId()
    {
        return $this->_getData(BlogInterface::BLOG_ID);
    }

    /**
     * @inheritdoc
     */
    public function setBlogId($id)
    {
        $this->setData(BlogInterface::BLOG_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getTheme()
    {
        return $this->_getData(BlogInterface::THEME);
    }

    /**
     * @inheritdoc
     */
    public function setTheme($theme)
    {
        $this->setData(BlogInterface::THEME, $theme);
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        return $this->_getData(BlogInterface::CONTENT);
    }

    /**
     * @inheritdoc
     */
    public function setContent($content)
    {
        $this->setData(BlogInterface::CONTENT, $content);
    }

    /**
     * @inheritdoc
     */
    public function getImagePath()
    {
        return $this->_getData(BlogInterface::IMAGE_PATH);
    }

    /**
     * @inheritdoc
     */
    public function setImagePath($imagePath)
    {
        $this->setData(BlogInterface::IMAGE_PATH, $imagePath);
    }

    /**
     * @inheritdoc
     */
    public function getCreationTime()
    {
        return $this->_getData(BlogInterface::CREATION_TIME);
    }

    /**
     * @inheritdoc
     */
    public function setCreationTime($creationTime)
    {
        $this->setData(BlogInterface::CREATION_TIME, $creationTime);
    }
}
