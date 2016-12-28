<?php
/**
 * The Recipe Post Type
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since  1.0
 */

namespace Wp\Recipe;

use Wp\Theme\PostParent;

/**
 * The Recipe Post Type
 *
 * @class   Register
 * @package \Wp\Recipe
 */
class Register extends PostParent
{
    /**
     * The singleton instance
     *
     * @const
     * @var null
     * @static
     * @since 1.0.1
     */
    protected static $instance = null;

    /**
     * Constructor
     *
     * @since 1.0.1
     */
    public function __construct()
    {
        $this->singularName = 'Recipe';
        $this->pluralName = 'Recipes';
        $this->menuIcon = 'dashicons-carrot';
        $this->supports = array('title', 'editor', 'thumbnail');
        $this->taxonomies = array('category', 'post_tag');
        parent::__construct();
    }

}
