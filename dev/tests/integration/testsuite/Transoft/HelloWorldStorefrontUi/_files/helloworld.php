<?php
declare(strict_types=1);

use Magento\TestFramework\Helper\Bootstrap;
use Transoft\HelloWorld\Model\HelloWorld;
use Transoft\HelloWorldAPI\Api\HelloWorldRepositoryInterface;

$objectManager = Bootstrap::getObjectManager();

/** @var HelloWorldRepositoryInterface $repository */
$repository = $objectManager->get(HelloWorldRepositoryInterface::class);
$model = $objectManager->create(HelloWorld::class)->setContent('HelloWorldContent9999');

$repository->save($model);
