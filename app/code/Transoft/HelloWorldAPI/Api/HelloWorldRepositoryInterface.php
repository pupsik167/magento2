<?php
declare(strict_types=1);

namespace Transoft\HelloWorldAPI\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Transoft\HelloWorldAPI\Api\Data\HelloWorldInterface;

interface HelloWorldRepositoryInterface
{
    /**
     * Saves hello to repository
     *
     * @param HelloWorldInterface $helloWorld
     * @return HelloWorldInterface
     * @throws CouldNotSaveException
     */
    public function save(HelloWorldInterface $helloWorld) : HelloWorldInterface;

    /**
     * Returns HelloWorld
     *
     * @param int|string $id
     * @return HelloWorldInterface
     * @throws NoSuchEntityException
     */
    public function get($id) : HelloWorldInterface;
}
