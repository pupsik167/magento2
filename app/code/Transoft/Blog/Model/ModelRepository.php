<?php
declare(strict_types=1);

namespace Transoft\Blog\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Transoft\Blog\Api\Data\ModelInterface;
use Transoft\Blog\Api\Data\ModelInterfaceFactory;
use Transoft\Blog\Api\Data\ModelSearchResultsInterface;
use Transoft\Blog\Api\Data\ModelSearchResultsInterfaceFactory;
use Transoft\Blog\Api\ModelRepositoryInterface;
use Transoft\Blog\Model\ResourceModel\Model as ResourceModel;
use Transoft\Blog\Model\ResourceModel\Model\Collection;
use Transoft\Blog\Model\ResourceModel\Model\CollectionFactory as ModelCollectionFactory;

/**
 * Class BlockRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ModelRepository implements ModelRepositoryInterface
{
    /**
     * @var ResourceModel $resource
     */
    protected $resource;

    /**
     * @var ModelFactory $modelFactory
     */
    protected $modelFactory;

    /**
     * @var ModelCollectionFactory $modelCollectionFactory
     */
    protected $modelCollectionFactory;

    /**
     * @var ModelSearchResultsInterfaceFactory $searchResultsFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper $dataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor $dataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var ModelInterfaceFactory $datamodelFactory
     */
    protected $datamodelFactory;

    /**
     * @var StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface $collectionProcessor
     */
    private $collectionProcessor;

    /**
     * @param ResourceModel $resource
     * @param ModelFactory $modelFactory
     * @param ModelInterfaceFactory $datamodelFactory
     * @param ModelCollectionFactory $modelCollectionFactory
     * @param ModelSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceModel $resource,
        ModelFactory $modelFactory,
        ModelInterfaceFactory $datamodelFactory,
        ModelCollectionFactory $modelCollectionFactory,
        ModelSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->modelFactory = $modelFactory;
        $this->modelCollectionFactory = $modelCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->datamodelFactory = $datamodelFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * Save Blog data
     *
     * @param ModelInterface $model
     * @return ModelInterface
     * @throws CouldNotSaveException
     */
    public function save(ModelInterface $model)
    {
        try {
            $this->resource->save($model);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $model;
    }

    /**
     * Load Model data by given Model Identity
     *
     * @param string $id
     * @return Model
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $model = $this->modelFactory->create();
        $this->resource->load($model, $id);
        if (!$model->getId()) {
            throw new NoSuchEntityException(__('The post with the "%1" ID doesn\'t exist.', $id));
        }
        return $model;
    }

    /**
     * Load Blog data collection by given search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return ModelSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        /** @var Collection $collection */
        $collection = $this->modelCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var ModelSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete Blog
     *
     * @param ModelInterface $model
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ModelInterface $model)
    {
        try {
            $this->resource->delete($model);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Blog by given Blog Identity
     *
     * @param string $blockId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($blockId)
    {
        return $this->delete($this->getById($blockId));
    }

    /**
     * Returns collection processor
     *
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = ObjectManager::getInstance()->get(
                'Transoft\Blog\Model\Api\SearchCriteria\ModelCollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }
}
