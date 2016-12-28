<?php
/**
 * Header Meta
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Landmark\Meta;

use Wp\Landmark\Controller\Menu;
use Wp\Theme\MetaParent;

/**
 * Class Header
 *
 * @package Wp\Post\Meta\Site
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Header extends MetaParent {
    /**
     * Return the menu for the header
     *
     * @return array
     * @since 1.0
     */
    public function getMenu()
    {
        $menu = new Menu('primary','primary');
        return $menu->getData();
    }

    /**
     * Get the logo url
     *
     * @return string
     * @since 1.0
     */
    public function getLogoUrl()
    {
        return get_template_directory_uri() . '/assets/media/images/logo.png';
    }
}