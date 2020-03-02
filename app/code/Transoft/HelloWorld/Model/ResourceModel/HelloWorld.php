<?php
declare(strict_types=1);

namespace Transoft\HelloWorld\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Transoft\HelloWorldAPI\Api\Data\HelloWorldInterface;

/**
 * Define hello resource model
 */
class HelloWorld extends AbstractDb
{
    protected $_idFieldName = 'id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('transoft_hello_world', HelloWorldInterface::ID);
    }
}
