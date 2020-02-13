<?php
declare(strict_types=1);

namespace Transoft\Blog\Model;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Filesystem\Io\File;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Transoft\Blog\Model\ResourceModel\Blog\CollectionFactory;

/**
 * Blog model ui data provider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private $_loadedData;

    /**
     * @var File $file
     */
    private $file;

    /**
     * @var BlogRepository
     */
    private $blogRepository;

    /**
     * @var SearchCriteriaBuilder $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param File $file
     * @param CollectionFactory $blogCollectionFactory
     * @param BlogRepository $blogRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        File $file,
        CollectionFactory $blogCollectionFactory,
        BlogRepository $blogRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $blogCollectionFactory->create();
        $this->file = $file;
        $this->blogRepository = $blogRepository;
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

        $items = $this->blogRepository->getList(($this->searchCriteriaBuilder->create()))->getItems();

        foreach ($items as $post) {
            $postData = $post->getData();
            $pathParts = $this->file->getPathInfo($postData['image_path']);
            $postImg = [
                [
                    'type' => 'image',
                    'name' => $pathParts['filename'],
                    'url' => $postData['image_path']
                ]
            ];
            $postData['image_path'] = $postImg;
            $this->_loadedData[$post->getId()] = $postData;
        }

        return $this->_loadedData;
    }
}
