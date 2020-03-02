<?php
declare(strict_types=1);

namespace Transoft\HelloWorldPlugins\Plugin;

use Transoft\HelloWorldStorefrontUi\Block\HelloWorld;

/**
 * HelloWorld after and around plugin
 */
class HelloWorldPlugin
{
    /**
     * Provides suffix for hello content
     *
     * @param HelloWorld $subject
     * @param string $result
     * @return string
     */
    public function afterGetHelloContent(HelloWorld $subject, $result)
    {
        return $result . '_suffix';
    }

    /**
     * Provides prefix and h1 tags for hello content
     *
     * @param HelloWorld $subject
     * @param \Closure $proceed
     * @return string
     */
    public function aroundGetHelloContent(HelloWorld $subject, \Closure $proceed)
    {
        $returnValue = $proceed();
        return 'Prefix_' . '<h1>' . $subject->escapeHtml($returnValue) . '</h1>';
    }
}
