<?php
declare(strict_types=1);
namespace Transoft\Blog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 *
 * Blog helper class
 */
class Data extends AbstractHelper
{
    /**
     * Returns config
     *
     * @param string $config_path
     *
     * @return mixed
     */
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            ScopeInterface::SCOPE_STORE
        );
    }
}
