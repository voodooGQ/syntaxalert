<?php
/**
 * Handles the configuration and setup of the administrative based items
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since  1.0
 */

namespace Wp\Theme;

/**
 * Handles the configuration and setup of the administrative based items
 *
 * @class   Admin
 * @package Wp\Theme
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Admin
{
    /**
     * Constructor
     *
     * @since 1.0
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Initialize
     *
     * @return $this
     * @since 1.0
     */
    public function init()
    {
        return $this->actions();
    }

    /**
     * Handles all action hook interactions
     *
     * @return $this
     * @since 1.0
     */
    private function actions()
    {
        add_action('admin_init', array(&$this, 'hideSubMenuItems'), 99);
        add_action('admin_menu', array(&$this, 'hideMenuItems'), 99);
        return $this;
    }

    /**
     * Hides items from the administration menu
     *
     * @return $this
     * @since 1.0
     */
    public function hideMenuItems()
    {
        if(THEME_ENV === 'prod') {
            // Posts
            remove_menu_page('edit.php');
            // Comments
            remove_menu_page('edit-comments.php');
        }
        return $this;
    }

    /**
     * Hides items from the administrative sub menus
     *
     * @return $this
     * @since 1.0
     */
    public function hideSubMenuItems()
    {
        if(THEME_ENV === 'prod') {
            // Appearance > Customize
            remove_submenu_page('themes.php', 'customize.php?return=%2Fcore%2Fwp-admin%2F');
            // Appearance > Editor
            remove_submenu_page('themes.php', 'theme-editor.php');
            // Plugins > Editor
            remove_submenu_page('plugins.php', 'plugin-editor.php');
        }
        return $this;
    }
}
