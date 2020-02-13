<?php
declare(strict_types=1);

namespace Transoft\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException;
use Transoft\Blog\Api\Data\BlogInterface;

interface BlogRepositoryInterface
{
    /**
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws CouldNotSaveException
     */
    public function save(BlogInterface $blog);

    /**
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog);

    /**
     * @param int $id
     * @return void
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id);

    /**
     * @param int $id
     * @return BlogInterface
     * @throws NoSuchEntityException
     */
    public function getById($id);

    /**
     * @api
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     * @throws InputException
     */
    public function getList(SearchCriteriaInterface $criteria);
}
