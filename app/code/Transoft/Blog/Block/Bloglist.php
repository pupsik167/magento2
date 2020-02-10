<?php
declare(strict_types=1);

namespace Transoft\Blog\Block;

use Magento\Catalog\Model\Locator\RegistryLocator;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\Template;
use Transoft\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * Generates blog list
 */
class Bloglist extends Template implements ArgumentInterface
{
    /**
     * @var PostCollectionFactory
     */
    protected $postCollection;

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
     * Constructor.
     *
     * @param PostCollectionFactory $postCollectionFactory
     * @param RequestInterface $request
     * @param UrlInterface $urlBuilder
     * @param RegistryLocator $registryLocator
     * @param ScopeConfigInterface $scopeInterface
     */
    public function __construct(
        PostCollectionFactory $postCollectionFactory,
        RequestInterface $request,
        UrlInterface $urlBuilder,
        RegistryLocator $registryLocator,
        ScopeConfigInterface $scopeInterface
    ) {
        $this->postCollection = $postCollectionFactory;
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
        $this->registryLocator = $registryLocator;
        $this->scopeInterface = $scopeInterface;
    }

    /**
     * Returns model collection
     *
     * @return mixed
     */
    public function getPostCollection()
    {
        $collection = $this->postCollection->create();
        $collection->setOrder('creation_time', 'DESC')->setPageSize(5);
        return $collection;
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

    /**
     * Returns blog by id
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getBlogById($id)
    {
        $item = $this->postCollection->create()
            ->addFieldToFilter('blog_id', ['eq' => $id])->getFirstItem();

        return $item;
    }
}
