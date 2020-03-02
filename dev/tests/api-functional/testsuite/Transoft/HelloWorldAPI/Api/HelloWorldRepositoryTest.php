<?php
declare(strict_types=1);

namespace Transoft\HelloWorldAPI\Api;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Transoft\HelloWorldAPI\Api\Data\HelloWorldInterface;
use Transoft\HelloWorldAPI\Api\Data\HelloWorldInterfaceFactory;

/**
 * Tests for HelloWorld repository.
 */
class HelloWorldRepositoryTest extends WebapiAbstract
{
    const SERVICE_NAME = 'helloWorldAPIBlockRepositoryV1';
    const SERVICE_VERSION = 'V1';
    const RESOURCE_PATH = '/V1/HelloWorld';

    /**
     * @var HelloWorldInterfaceFactory
     */
    protected $helloInterfaceFactory;

    /**
     * @var HelloWorldRepositoryInterface
     */
    protected $helloRepository;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var HelloWorldInterface|null
     */
    protected $currentHello;

    /**
     * Execute per test initialization.
     */
    public function setUp()
    {
        $this->helloInterfaceFactory = Bootstrap::getObjectManager()
            ->create(HelloWorldInterfaceFactory::class);
        $this->helloRepository = Bootstrap::getObjectManager()
            ->create(HelloWorldRepositoryInterface::class);
        $this->dataObjectHelper = Bootstrap::getObjectManager()->create(DataObjectHelper::class);
        $this->dataObjectProcessor = Bootstrap::getObjectManager()
            ->create(DataObjectProcessor::class);
    }

    /**
     * Test get Transoft\HelloWorldAPI\Api\Data\HelloWorldInterface
     */
    public function testGet()
    {
        $content = 'Test content';

        /** @var  HelloWorldInterface $helloDataObject */
        $helloDataObject = $this->helloInterfaceFactory->create();
        $helloDataObject->setContent($content);
        $this->currentHello = $this->helloRepository->save($helloDataObject);

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '/' . $this->currentHello->getId(),
                'httpMethod' => Request::HTTP_METHOD_GET,
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'serviceVersion' => self::SERVICE_VERSION,
                'operation' => self::SERVICE_NAME . 'Get',
            ],
        ];

        $hello = $this->_webApiCall($serviceInfo, [HelloWorldInterface::ID => $this->currentHello->getId()]);
        $this->assertNotNull($hello['id']);

        /** @var HelloWorldInterface $helloData */
        $helloData = $this->helloRepository->get($hello['id']);

        $this->assertEquals($helloData->getContent(), $content);
    }

    /**
     * Test create Transoft\HelloWorldAPI\Api\Data\HelloWorldInterface
     */
    public function testCreate()
    {
        $content = 'Test content';

        /** @var  HelloWorldInterface $helloDataObject */
        $helloDataObject = $this->helloInterfaceFactory->create();
        $helloDataObject->setContent($content);

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod' => Request::HTTP_METHOD_POST,
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'serviceVersion' => self::SERVICE_VERSION,
                'operation' => self::SERVICE_NAME . 'Save',
            ],
        ];

        $requestData = ['helloWorld' => [
            HelloWorldInterface::CONTENT => $helloDataObject->getContent()
            ]
        ];
        $hello = $this->_webApiCall($serviceInfo, $requestData);
        $this->assertNotNull($hello['id']);

        $this->currentHello = $this->helloRepository->get($hello['id']);
        $this->assertEquals($this->currentHello->getContent(), $content);
    }
}
