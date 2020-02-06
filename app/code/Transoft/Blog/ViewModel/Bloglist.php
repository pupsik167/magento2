<?php
declare(strict_types=1);
namespace Transoft\Blog\ViewModel;

use Magento\Catalog\Block\Product\View;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Transoft\Blog\Model\ResourceModel\Post\Collection;
use Transoft\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * Class Bloglist
 *
 * Blog list view model class
 */
class Bloglist implements ArgumentInterface
{
    /**
     * @var PostCollectionFactory
     */
    protected $postCollectionFactory;

    /**
     * ScopeConfigInterface $scopeInterface
     */
    private $scopeInterface;

    /**
     * UrlInterface $urlInterface
     */
    private $urlInterface;

    /**
     * Constructor.
     *
     * @param PostCollectionFactory $postCollectionFactory
     * @param UrlInterface $urlInterface
     * @param ScopeConfigInterface $scopeInterface
     */
    public function __construct(
        PostCollectionFactory $postCollectionFactory,
        UrlInterface $urlInterface,
        ScopeConfigInterface $scopeInterface
    ) {
        $this->postCollectionFactory = $postCollectionFactory;
        $this->urlInterface = $urlInterface;
        $this->scopeInterface = $scopeInterface;
    }

    /**
     * Returns model collection
     *
     * @return Collection
     */
    public function getPostCollection()
    {
        $collection = $this->postCollectionFactory->create();
        $collection->setOrder('creation_time', 'DESC')->setPageSize(5);

        return $collection;
    }

    /**
     * Check if types matching
     *
     * @return bool
     */
    public function isTypesMatching() : bool
    {
        $types = $this->scopeInterface->getValue('catalog/blog/blog_applied_to');
        $product = ObjectManager::getInstance()->get(View::class);
        $current_product_type = $product->getProduct()->getTypeId();
        $types_array = explode(',', $types);
        return in_array($current_product_type, $types_array);
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
        return $this->urlInterface->getUrl("blog/blog/index?id=$id");
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
        $item = $this->postCollectionFactory->create()
            ->addFieldToFilter('blog_id', ['eq' => $id])->getFirstItem();

        return $item->getData();
    }
}
