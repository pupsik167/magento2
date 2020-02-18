<?php
declare(strict_types=1);

namespace Transoft\Blog\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Transoft\Blog\Api\BlogRepositoryInterface;
use Transoft\Blog\Api\Data\BlogInterface;
use Transoft\Blog\Api\Data\BlogInterfaceFactory;
use Transoft\Blog\Model\ResourceModel\Blog as ResourceModel;
use Transoft\Blog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;

/**
 * Model blog repository
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BlogRepository implements BlogRepositoryInterface
{
    /**
     * @var ResourceModel $resource
     */
    protected $resource;

    /**
     * @var BlogCollectionFactory $blogCollectionFactory
     */
    protected $blogCollectionFactory;

    /**
     * @var SearchResultsInterfaceFactory $searchResultsFactory
     */
    protected $searchResultsFactory;

    /**
     * @var BlogInterfaceFactory $blogFactory
     */
    protected $blogFactory;

    /**
     * @var CollectionProcessorInterface $collectionProcessor
     */
    private $collectionProcessor;

    /**
     * @param ResourceModel $resource
     * @param BlogInterfaceFactory $blogFactory
     * @param BlogCollectionFactory $blogCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceModel $resource,
        BlogInterfaceFactory $blogFactory,
        BlogCollectionFactory $blogCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->blogFactory = $blogFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save Blog data
     *
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws CouldNotSaveException
     */
    public function save(BlogInterface $blog) : BlogInterface
    {
        try {
            $this->resource->save($blog);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $blog;
    }

    /**
     * Load Model data by given Model Identity
     *
     * @param string $id
     * @return BlogInterface
     * @throws NoSuchEntityException
     */
    public function getById($id) : BlogInterface
    {
        $blog = $this->blogFactory->create();
        $this->resource->load($blog, $id);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('The post with the "%1" ID doesn\'t exist.', $id));
        }
        return $blog;
    }

    /**
     * Load Blog data collection by given search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $criteria) : SearchResultsInterface
    {
        $collection = $this->blogCollectionFactory->create();

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

    /**
     * Delete Blog
     *
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog) : BlogInterface
    {
        try {
            $this->resource->delete($blog);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return $blog;
    }

    /**
     * Delete Blog by given Blog Identity
     *
     * @param string $blogId
     * @return BlogInterface
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($blogId) : BlogInterface
    {
        return $this->delete($this->getById($blogId));
    }
}
