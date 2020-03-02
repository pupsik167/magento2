<?php
declare(strict_types=1);

namespace Transoft\HelloWorld\Model\ResourceModel\HelloWorld;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Transoft\HelloWorld\Model\HelloWorld;
use Transoft\HelloWorld\Model\ResourceModel\HelloWorld as ResourceModelHelloWorld;

/**
 * Define hello collection
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'transoft_hello_world_collection';
    protected $_eventObject = 'hello_world_collection';

    /**
     * Define hello world resource model collection
     */
    protected function _construct()
    {
        $this->_init(HelloWorld::class, ResourceModelHelloWorld::class);
    }
}
