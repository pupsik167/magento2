<?php
declare(strict_types=1);

namespace Transoft\Blog\Model;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Filesystem\Io\File;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Transoft\Blog\Model\ModelRepository;
use Transoft\Blog\Model\ResourceModel\Model\CollectionFactory;

/**
 * Blog model ui data provider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $_loadedData;

    /**
     * @var File $file
     */
    private $file;

    /**
     * @var ModelRepository
     */
    private $modelRepository;

    /**
     * @var SearchCriteriaBuilder $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param File $file
     * @param CollectionFactory $postCollectionFactory
     * @param ModelRepository $modelRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        File $file,
        CollectionFactory $postCollectionFactory,
        ModelRepository $modelRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $postCollectionFactory->create();
        $this->file = $file;
        $this->modelRepository = $modelRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $items = $this->modelRepository->getList(($this->searchCriteriaBuilder->create()))->getItems();

        foreach ($items as $post) {
            $postData = $post->getData();
            $path_parts = $this->file->getPathInfo($postData['image_path']);
            $postImg = [
                ['type'=>'image',
                 'name' => $path_parts['filename'],
                 'url' => $postData['image_path']
                ]
            ];
            $postData['image_path'] = $postImg;
            $this->_loadedData[$post->getId()] = $postData;
        }

        return $this->_loadedData;
    }
}
