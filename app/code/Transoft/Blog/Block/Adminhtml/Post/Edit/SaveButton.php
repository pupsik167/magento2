<?php
declare(strict_types=1);
namespace Transoft\Blog\Block\Adminhtml\Post\Edit;

use Magento\Cms\Block\Adminhtml\Block\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 *
 * Generates save button
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get save button params
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Post'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            //'on_click' => sprintf("location.href= '%s';", $this->getSaveUrl()),
            'sort_order' => 90
        ];
    }

    /**
     * Get save url
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', []);
    }
}
