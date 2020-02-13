<?php
declare(strict_types=1);

namespace Transoft\Blog\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * UI component actions class
 */
class Actions extends Column
{
    /**
     * @inheritdoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['blog_id'])) {
                    $title = $item['theme'];
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->context->getUrl(
                                'blog/post/edit',
                                [
                                    'id' => $item['blog_id'],
                                ]
                            ),
                            'label' => __('Edit'),
                            '__disableTmpl' => true,
                        ],
                        'delete' => [
                            'href' => $this->context->getUrl(
                                'blog/post/delete',
                                [
                                    'id' => $item['blog_id'],
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete %1', $title),
                                'message' => __('Are you sure you want to delete a %1 record?', $title),
                            ],
                            'post' => true,
                            '__disableTmpl' => true,
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
