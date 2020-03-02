<?php
declare(strict_types=1);

namespace Transoft\HelloWorldStorefrontUi\Test\Integration\Controller\Hello;

use Magento\TestFramework\TestCase\AbstractController;

class HelloTest extends AbstractController
{
    /**
     * @magentoDataFixture Transoft/HelloWorldStorefrontUi/_files/hello_world.php
     */
    public function testIndexAction()
    {
        $this->dispatch(sprintf('hello-world/hello/index'));
        $responseBody = $this->getResponse()->getBody();

        $this->assertContains('HelloWorldContent9999', $responseBody);
    }
}
