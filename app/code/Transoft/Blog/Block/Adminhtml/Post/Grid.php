<?php
declare(strict_types=1);
namespace Transoft\Blog\Block\Adminhtml\Post;

use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Class Grid
 *
 * Post admin grid class
 */
class Grid extends Container
{
    /**
     * Grid constructor
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Transoft_Blog';
        $this->_controller = 'adminhtml_blog';
        $this->_headerText = __('Manage Blogs');
        $this->_addButtonLabel = __('Add New Blog');
        parent::_construct();
    }
}
