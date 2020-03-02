<?php
declare(strict_types=1);

namespace Transoft\HelloWorldStorefrontUi\Block;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Transoft\HelloWorldAPI\Api\HelloWorldRepositoryInterface as HelloWorldRepository;

/**
 * Generates hello world storefront block
 */
class HelloWorld extends Template
{
    /**
     * @var HelloWorldRepository
     */
    private $helloWorldRepository;

    /**
     * @var SortOrderBuilder $sortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @var SearchCriteriaBuilder $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Creates hello world block
     *
     * @param Context $context
     * @param HelloWorldRepository $helloWorldRepository
     * @param SortOrderBuilder $sortOrderBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        HelloWorldRepository $helloWorldRepository,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        $this->helloWorldRepository = $helloWorldRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    /**
     * Returns hello world content
     *
     * @return string
     */
    public function getHelloContent() : string
    {
        $this->sortOrderBuilder->setField('id');
        $this->sortOrderBuilder->setAscendingDirection();
        $this->searchCriteriaBuilder->addSortOrder($this->sortOrderBuilder->create());
        $this->searchCriteriaBuilder->setPageSize(1);

        /** @var SearchResultsInterface $searchResult */
        $searchResult = $this->helloWorldRepository->getList(($this->searchCriteriaBuilder->create()));
        $items = $searchResult->getItems();

        return $items[1]->getContent();
    }
}
