<?php
declare(strict_types=1);

namespace Transoft\HelloWorld\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Transoft\HelloWorld\Model\HelloWorldFactory as HelloWorldFactory;
use Transoft\HelloWorld\Model\ResourceModel\HelloWorld as ResourceModel;
use Transoft\HelloWorld\Model\ResourceModel\HelloWorld\CollectionFactory as CollectionFactory;
use Transoft\HelloWorldAPI\Api\Data\HelloWorldInterface;
use Transoft\HelloWorldAPI\Api\HelloWorldRepositoryInterface;

/**
 * Hello world repository
 *
 * Provides HelloWorld repository methods
 */
class HelloWorldRepository implements HelloWorldRepositoryInterface
{
    /**
     * @var ResourceModel $resource
     */
    private $resource;

    /**
     * @var CollectionFactory $collectionFactory
     */
    private $collectionFactory;

    /**
     * @var SearchResultsInterfaceFactory $searchResultsFactory
     */
    private $searchResultsFactory;

    /**
     * @var HelloWorldFactory $helloWorldFactory
     */
    private $helloWorldFactory;

    /**
     * @var CollectionProcessorInterface $collectionProcessor
     */
    private $collectionProcessor;

    /**
     * @param ResourceModel $resource
     * @param HelloWorldFactory $helloWorldFactory
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceModel $resource,
        HelloWorldFactory $helloWorldFactory,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->helloWorldFactory = $helloWorldFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save collection data to repository
     *
     * @param HelloWorldInterface $helloWorld
     * @return HelloWorldInterface
     * @throws CouldNotSaveException
     */
    public function save(HelloWorldInterface $helloWorld) : HelloWorldInterface
    {
        try {
            $this->resource->save($helloWorld);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $helloWorld;
    }

    /**
     * Load Model data by given Model Identity
     *
     * @param int|string $id
     * @return HelloWorldInterface
     * @throws NoSuchEntityException
     */
    public function get($id) : HelloWorldInterface
    {
        $helloworld = $this->helloWorldFactory->create();
        $this->resource->load($helloworld, $id);

        if (!$helloworld) {
            throw new NoSuchEntityException(__('This record doesn\'t exist.'));
        }
        return $helloworld;
    }

    /**
     * Load collection data by given search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $criteria) : SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        try {
            $this->collectionProcessor->process($criteria, $collection);
        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
