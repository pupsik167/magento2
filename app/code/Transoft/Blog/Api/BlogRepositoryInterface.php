<?php
declare(strict_types=1);

namespace Transoft\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException;
use Transoft\Blog\Api\Data\BlogInterface;

interface BlogRepositoryInterface
{
    /**
     * Saves blog to repository
     *
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws CouldNotSaveException
     */
    public function save(BlogInterface $blog) : BlogInterface;

    /**
     * Deletes blog from repository
     *
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog) : BlogInterface;

    /**
     * Deletes blog from repository by id
     *
     * @param int $id
     * @return BlogInterface
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id) : BlogInterface;

    /**
     * Returns blog by id
     *
     * @param int $id
     * @return BlogInterface
     * @throws NoSuchEntityException
     */
    public function getById($id) : BlogInterface;

    /**
     * Returns blog list
     *
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     * @throws InputException
     */
    public function getList(SearchCriteriaInterface $criteria) : SearchResultsInterface;
}
