<?php
declare(strict_types=1);

namespace Transoft\HelloWorld\Model;

use Magento\Framework\Model\AbstractModel;
use Transoft\HelloWorldAPI\Api\Data\HelloWorldInterface;

/**
 * Hello world model class
 */
class HelloWorld extends AbstractModel implements HelloWorldInterface
{
    /**
     * Define hello resource model
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\HelloWorld::class);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->_getData(HelloWorldInterface::ID);
    }

    /**
     * @inheritdoc
     */
    public function setId($id) : HelloWorldInterface
    {
        return $this->setData(HelloWorldInterface::ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getContent() : string
    {
        return $this->_getData(HelloWorldInterface::CONTENT);
    }

    /**
     * @inheritdoc
     */
    public function setContent($content) : HelloWorldInterface
    {
        return $this->setData(HelloWorldInterface::CONTENT, $content);
    }
}
