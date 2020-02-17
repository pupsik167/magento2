<?php
declare(strict_types=1);

namespace Transoft\Blog\Block;

use Magento\Catalog\Model\Locator\RegistryLocator;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Transoft\Blog\Model\BlogRepository;

/**
 * Generates blog list
 */
class Bloglist extends Template
{
    /**
     * ScopeConfigInterface $scopeInterface
     */
    private $scopeInterface;

    /**
     * @var RegistryLocator $registryLocator
     */
    private $registryLocator;

    /**
     * @var BlogRepository
     */
    private $blogRepository;

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
     * @param Context $context
     * @param RegistryLocator $registryLocator
     * @param ScopeConfigInterface $scopeInterface
     * @param BlogRepository $blogRepository
     * @param SortOrderBuilder $sortOrderBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        RegistryLocator $registryLocator,
        ScopeConfigInterface $scopeInterface,
        BlogRepository $blogRepository,
        SortOrderBuilder $sortOrderBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        $this->registryLocator = $registryLocator;
        $this->scopeInterface = $scopeInterface;
        $this->blogRepository = $blogRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    /**
     * Returns model collection items
     *
     * @return array
     * @throws LocalizedException
     */
    public function getLatestPostItems()
    {
        $this->sortOrderBuilder->setField('creation_time');
        $this->sortOrderBuilder->setDescendingDirection();
        $this->searchCriteriaBuilder->addSortOrder($this->sortOrderBuilder->create());
        $this->searchCriteriaBuilder->setPageSize(5);
        $searchResult = $this->blogRepository->getList(($this->searchCriteriaBuilder->create()));
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
        return $this->getRequest()->getParam('id');
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
        return $this->getUrl('blog/blog/view', ['id' => $id]);
    }

    /**
     * Returns json config
     *
     * @return string
     * @throws LocalizedException
     */
    public function getConfig()
    {
        $data = $this->getLatestPostItems();
        $jsonConfig = [];

        foreach ($data as $item) {
            array_push($jsonConfig, [
                'theme' => $item->getTheme(),
                'url' => $this->getUrlById((int)$item->getBlogId())
            ]);
        }

        $jsonConfig['length'] = count($jsonConfig);
        $jsonConfig['title'] = __('Latest 5 blogs:');

        return json_encode($jsonConfig);
    }
}
