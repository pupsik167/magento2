<?php
declare(strict_types=1);
namespace Transoft\Blog\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Transoft\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * Class Singleblog
 *
 * Single blog view model class
 */
class Singleblog implements ArgumentInterface
{
    /**
     * @var PostCollectionFactory
     */
    protected $modelFactory;

    /**
     * Constructor.
     *
     * @param PostCollectionFactory $modelFactory
     */
    public function __construct(
        PostCollectionFactory $modelFactory
    ) {
        $this->modelFactory = $modelFactory;
    }

    /**
     * Returns blog by id
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getBlogById($id = 1)
    {
        $collection = $this->modelFactory->create()->getData();
        $item = [];
        foreach ($collection as $value) {
            if ($value['blog_id'] === $id) {
                $item = $value;
                break;
            }
        }
        return $item;
    }
}
