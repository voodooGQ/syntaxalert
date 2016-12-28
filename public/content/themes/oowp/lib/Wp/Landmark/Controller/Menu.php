<?php
/**
 * Menu Controller
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Landmark\Controller;

/**
 * Class Menu
 *
 * @package Wp\Landmark\Controller
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Menu
{
    /**
     * The menu location slug or menu id
     *
     * @var string
     */
    private $locationOrId;

    /**
     * The template being used
     *
     * @var string;
     * @since 1.0
     */
    private $template;

    /**
     * Templates available
     *
     * @var array
     */
    private $availableTemplates = array(
        'primary'    => 'landmark/menu/primary',
    );

    /**
     * Constructor
     *
     * @param string $locationOrId
     * @param string $template
     * @since 1.0
     */
    public function __construct($template, $locationOrId) {
        $this->template = $template;
        $this->locationOrId = $locationOrId;
    }

    /**
     * Returns the name of the Twig Template to use
     *
     * @return string
     * @since 1.0
     */
    public function getTemplateName()
    {
        return $this->availableTemplates[$this->template];
    }

    /**
     * Update WordPress Generated Menu Items
     *
     * @param string $slug
     * @return mixed
     * @since 1.0
     */
    public function updateMenuItems($slug) {
        global $post;
        $menuItems = wp_get_nav_menu_items($slug);

        foreach($menuItems as $item) {
            // Is Active Menu Item
            $item->is_active = false;
            if($post) {
                if (intval($item->object_id) == intval($post->ID)) {
                    $item->is_active = true;
                }
            }

            // Update Class List
            $classList = '';
            foreach($item->classes as $class) {
                $classList .= $class . ' ';
            }
            $item->classes = rtrim($classList, ' ');
        }

        return $menuItems;
    }

    /**
     * Returns the menu data for Twig
     *
     * @return array
     * @since 1.0
     */
    public function getData()
    {

        $twigData = array();

        $locations = get_nav_menu_locations();
        $menus = wp_get_nav_menus();

        $locationId = is_numeric($this->locationOrId)
            ? $this->locationOrId
            : $locations[$this->locationOrId];

        foreach($menus as $menu) {
            if($menu->term_id == $locationId) {
                $twigData['template'] = $this->template;
                $twigData['items'] = $this->updateMenuItems($menu->slug);

            }
        }

        return $twigData;
    }
}