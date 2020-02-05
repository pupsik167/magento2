<?php
declare(strict_types=1);
namespace Transoft\Blog\ViewModel;

use Magento\Catalog\Block\Product\View;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\ObjectManager;
use Transoft\Blog\Helper\Data;
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
    protected $modelFactory;

    /**
     * Transoft\Blog\Helper\Data $helper
     */
    protected $helper;

    /**
     * Constructor.
     *
     * @param PostCollectionFactory $modelFactory
     * @param Data $helper
     */
    public function __construct(
        PostCollectionFactory $modelFactory,
        Data $helper
    ) {
        $this->modelFactory = $modelFactory;
        $this->helper = $helper;
    }

    /**
     * Returns model collection
     *
     * @return Collection
     */
    public function retrieveModel()
    {
        $collection = $this->modelFactory->create();
        $collection->setOrder('creation_time', 'ASC')->setPageSize(5);

        return $collection;
    }

    /**
     * Check if types matching
     *
     * @return bool
     */
    public function isTypesMatching()
    {
        $types = $this->helper->getConfig('catalog/blog/blog_applied_to');
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
    public function getUrlById($id)
    {
        return "blog/blog/index?id=$id";
    }
}
