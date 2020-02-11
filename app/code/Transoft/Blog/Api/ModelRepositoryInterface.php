<?php
declare(strict_types=1);

namespace Transoft\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Transoft\Blog\Api\Data\ModelInterface;
use Transoft\Blog\Api\Data\ModelSearchResultsInterface;

interface ModelRepositoryInterface
{
    /**
     * @param ModelInterface $model
     * @return ModelInterface
     * @api
     */
    public function save(ModelInterface $model);

    /**
     * @param ModelInterface $model
     * @return ModelInterface
     * @api
     */
    public function delete(ModelInterface $model);

    /**
     * @param ModelInterface $id
     * @return void
     *@api
     */
    public function deleteById($id);

    /**
     * @param int $id
     * @return ModelInterface
     * @throws NoSuchEntityException
     *@api
     */
    public function getById($id);

    /**
     * @api
     * @param SearchCriteriaInterface $criteria
     * @return ModelSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria);
}
