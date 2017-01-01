<?php
/**
 * Footer Meta
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Landmark\Meta;

/**
 * Class Footer
 *
 * @package Wp\Post\Meta\Site
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Footer
{
    /**
     * Get the copyright string
     *
     * @return string
     * @since 1.0
     */
    public function getCopyright()
    {
        return '&copy; ' . date('Y') . ' - <a href="//shaneallensmith.com" target="_blank">Shane Smith</a>. All Rights Reserved.';
    }
}