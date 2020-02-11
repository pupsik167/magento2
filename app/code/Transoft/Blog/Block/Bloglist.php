<?php
declare(strict_types=1);

namespace Transoft\Blog\Block;

use Magento\Catalog\Model\Locator\RegistryLocator;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\Template;
use Transoft\Blog\Model\ModelRepository;

/**
 * Generates blog list
 */
class Bloglist extends Template implements ArgumentInterface
{
    /**
     * @var RequestInterface $request
     */
    private $request;

    /**
     * ScopeConfigInterface $scopeInterface
     */
    private $scopeInterface;

    /**
     * UrlInterface $urlInterface
     */
    private $urlBuilder;

    /**
     * @var RegistryLocator $registryLocator
     */
    private $registryLocator;

    /**
     * @var ModelRepository
     */
    private $modelRepository;

    /**
     * @var SortOrderBuilder $sortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @var SearchCriteriaBuilder $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Creates Bloglist block
     *
     * @param RequestInterface $request
     * @param UrlInterface $urlBuilder
     * @param RegistryLocator $registryLocator
     * @param ScopeConfigInterface $scopeInterface
     * @param ModelRepository $modelRepository
     * @param SortOrderBuilder $sortOrderBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        RequestInterface $request,
        UrlInterface $urlBuilder,
        RegistryLocator $registryLocator,
        ScopeConfigInterface $scopeInterface,
        ModelRepository $modelRepository,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
        $this->registryLocator = $registryLocator;
        $this->scopeInterface = $scopeInterface;
        $this->modelRepository = $modelRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Returns model collection items
     *
     * @return mixed
     */
    public function getLatestPostItems()
    {
        $this->sortOrderBuilder->setField('creation_time');
        $this->sortOrderBuilder->setDescendingDirection();
        $this->searchCriteriaBuilder->addSortOrder($this->sortOrderBuilder->create());
        $this->searchCriteriaBuilder->setPageSize(5);
        $searchResult = $this->modelRepository->getList(($this->searchCriteriaBuilder->create()));
        return $searchResult->getItems();
    }

    /**
     * Check if types are matching
     *
     * @return bool
     *
     * @throws NotFoundException
     */
    public function isTypesMatching()
    {
        $configTypes = $this->scopeInterface->getValue('catalog/blog/blog_applied_to');
        $productType = $this->registryLocator->getProduct()->getTypeId();
        $configTypesArray = explode(',', $configTypes);
        return in_array($productType, $configTypesArray);
    }

    /**
     * Returns blog id from request
     *
     * @return int
     */
    public function getBlogId()
    {
        return $this->request->getParam('id');
    }

    /**
     * Returns url
     *
     * @param integer $id
     *
     * @return string
     */
    public function getUrlById(int $id) : string
    {
        return $this->urlBuilder->getUrl('blog/blog/index', ['id' => $id]);
    }
}
