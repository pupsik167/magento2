<?php
declare(strict_types=1);

namespace Transoft\Blog\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * UI component thumbnail class
 */
class Thumbnail extends Column
{
    const ALT_FIELD = 'name';

    /**
     * @inheritdoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $filename = $item['image_path'];
                $item[$fieldName . '_src'] = $this->context->getUrl('', ['_direct' => '']) . $filename;
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: $filename;
                $item[$fieldName . '_orig_src'] = $this->context->getUrl('', ['_direct' => '']) . $filename;
            }
        }

        return $dataSource;
    }

    /**
     * Get alternative field
     *
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt(array $row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return $row[$altField] ?? null;
    }
}
