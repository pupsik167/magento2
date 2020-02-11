<?php
declare(strict_types=1);

namespace Transoft\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ModelSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return ModelInterface[]
     */
    public function getItems();

    /**
     * @param ModelInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
