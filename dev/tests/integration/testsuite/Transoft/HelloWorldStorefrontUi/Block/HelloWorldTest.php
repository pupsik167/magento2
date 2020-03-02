<?php
declare(strict_types=1);

namespace Transoft\HelloWorldStorefrontUi\Block;

use Magento\Framework\View\LayoutInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    /**
     * @var HelloWorld
     */
    protected $_block;

    protected function setUp()
    {
        parent::setUp();
        $this->_block = Bootstrap::getObjectManager()->get(
            LayoutInterface::class
        )->createBlock(
            HelloWorld::class
        );
    }

    /**
     * @magentoAppArea frontend
     * @magentoDataFixture Transoft/HelloWorldStorefrontUi/_files/hello_world.php
     */
    public function testGetHelloContent()
    {
        $this->assertEquals("<h1>HelloWorldContent9999</h1>_suffix", $this->_block->getHelloContent());
    }
}
