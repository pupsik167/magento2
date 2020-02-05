<?php
declare(strict_types=1);
namespace Transoft\Blog\Model;

use Magento\Framework\Filesystem\Io\File;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Transoft\Blog\Model\ResourceModel\Post\CollectionFactory;

/**
 * Class DataProvider
 *
 * Generates data provider
 */
class DataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;
    private $file;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param File $file
     * @param CollectionFactory $postCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        File $file,
        CollectionFactory $postCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $postCollectionFactory->create();
        $this->file = $file;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get provider data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $post) {
            $postData = $post->getData();
            $path_parts = $this->file->getPathInfo($postData['image_url']);
            $post_img = [
                ['type'=>'image',
                 'name' => $path_parts['filename'],
                 'url' => $postData['image_url']
                ]
            ];
            $postData['image_url'] = $post_img;
            $this->_loadedData[$post->getId()] = $postData;
        }

        return $this->_loadedData;
    }
}
