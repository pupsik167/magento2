<?php
declare(strict_types=1);

namespace Transoft\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Transoft\Blog\Api\Data\ModelInterface;

class Model extends AbstractModel implements ModelInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Model::class);
    }

    /**
     * @inheritdoc
     */
    public function getBlogId()
    {
        return $this->_getData(ModelInterface::BLOG_ID);
    }

    /**
     * @inheritdoc
     */
    public function setBlogId($id)
    {
        $this->setData(ModelInterface::BLOG_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getTheme()
    {
        return $this->_getData(ModelInterface::THEME);
    }

    /**
     * @inheritdoc
     */
    public function setTheme($theme)
    {
        $this->setData(ModelInterface::THEME, $theme);
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        return $this->_getData(ModelInterface::CONTENT);
    }

    /**
     * @inheritdoc
     */
    public function setContent($content)
    {
        $this->setData(ModelInterface::CONTENT, $content);
    }

    /**
     * @inheritdoc
     */
    public function getImagePath()
    {
        return $this->_getData(ModelInterface::IMAGE_PATH);
    }

    /**
     * @inheritdoc
     */
    public function setImagePath($imagePath)
    {
        $this->setData(ModelInterface::IMAGE_PATH, $imagePath);
    }

    /**
     * @inheritdoc
     */
    public function getCreationTime()
    {
        return $this->_getData(ModelInterface::CREATION_TIME);
    }

    /**
     * @inheritdoc
     */
    public function setCreationTime($creationTime)
    {
        $this->setData(ModelInterface::CREATION_TIME, $creationTime);
    }
}
