<?php
/**
 * Parent class for all Post Type Setup Classes
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since  1.0
 */

namespace Wp\Theme;

/**
 * Parent class for all Post Types. Handles basic functionality and
 * registration.
 *
 * @see     http://codex.wordpress.org/Function_Reference/register_post_type
 * @class   PostParent
 * @package Wp\Post\Setup
 * @author  Shane Smith <voodoogq@gmail.com>
 */
class PostParent
{
    /**
     * The singleton instance
     *
     * @var null
     * @static
     * @since 1.0
     */
    protected static $instance = null;

    /**
     * The singular name of the post type
     *
     * @var string
     * @default ''
     * @since   1.0
     */
    protected $singularName = '';

    /**
     * The plural name of the post type
     *
     * @var string
     * @default ''
     * @since   1.0
     */
    protected $pluralName = '';

    /**
     * Is the post type intended to be used publicly?
     *
     * @var bool
     * @default true
     * @since   1.0
     */
    protected $public = true;

    /**
     * Enables post type archives.
     * Entering as a string will set the rewrite slug to that name
     *
     * @var bool|string
     * @default false
     * @since   1.0
     */
    protected $hasArchive = false;

    /**
     * Whether to exclude posts with this post type from front end search results
     *
     * @var bool
     * @default true
     * @since   1.0
     */
    protected $excludeFromSearch = true;

    /**
     * Whether queries can be performed on the front end as part of parse_request()
     *
     * @var bool
     * @default true
     * @since   1.0
     */
    protected $publiclyQueryable = true;

    /**
     * Whether the post type is available for selection in navigation menus.
     *
     * @var bool
     * @default false
     * @since   1.0
     */
    protected $showInNavMenus = false;

    /**
     * Where to show the post type in the admin menu.
     *
     * 'false' - do not display in the admin menu
     * 'true' - display as a top level menu
     * 'some string' - If an existing top level page such as 'tools.php' or 'edit.php?post_type=page',
     * the post type will be placed as a sub menu of that.
     *
     * @var bool|string
     * @default  true
     * @since    1.0
     */
    protected $showInMenu = true;

    /**
     * Whether to make this post type available in the WordPress admin bar.
     *
     * @var bool
     * @default false
     * @since   1.0
     */
    protected $showInAdminBar = false;

    /**
     * Determines what taxonomies are associated with the post type.
     *
     * @var array
     * @default empty array
     * @since   1.0
     */
    protected $taxonomies = array();

    /**
     * Whether the post type is hierarchical (e.g. page). Allows Parent to be specified.
     *
     * @var bool
     * @default false
     * @since   1.0
     */
    protected $hierarchical = false;

    /**
     * The url to the icon to be used for this menu or the name of the icon from dashicons
     *
     * @see     http://melchoyce.github.io/dashicons/
     * @var string
     * @default 'dashicons-list-view'
     * @since   1.0
     */
    protected $menuIcon = 'dashicons-list-view';

    /**
     * The string to use to build the read, edit, and delete capabilities.
     * May be passed as an array to allow for alternative plurals when using
     * this argument as a base to construct the capabilities, e.g. array('story', 'stories')
     * the first array element will be used for the singular capabilities and
     * the second array element for the plural capabilities, this is instead of
     * the auto generated version if no array is given which would be "storys".
     * The 'capability_type' parameter is used as a base to construct capabilities
     * unless they are explicitly set with the 'capabilities' parameter.
     * It seems that `map_meta_cap` needs to be set to true, to make this work.
     *
     * @var string|array
     * @default 'post'
     * @since   1.0
     */
    protected $capabilityType = 'post';

    /**
     * An alias for calling add_post_type_support() directly.
     *
     * @var array
     * @default array()
     * @since   1.0
     */
    protected $supports = array(
        'title', 'editor', 'thumbnail'
    );

    /**
     * Whether to show Yoast SEO configuration or not
     *
     * @var bool
     * @default true
     * @since 1.0
     */
    protected $showYoastSeo = true;

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
     * Initialize, hook into the theme
     *
     * @since 1.0
     */
    public function init()
    {
        add_action('init', array(&$this, 'registerPostType'), 50);

        if (!$this->showYoastSeo) {
            add_action('add_meta_boxes', array(&$this, 'removeYoastSeo'), 99);
        }
    }

    /**
     * Returns singleton instance
     *
     * @return $this||null
     * @since        1.0
     */
    public static function getInstance()
    {
        if (static::$instance == null) {
            $className = get_called_class();
            static::$instance = new $className();
        }
        return static::$instance;
    }

    /**
     * Returns the post type slug based on the singular name
     * Automatically converts to less then 20 characters
     *
     * @return string
     * @since 1.0
     */
    public function getPostTypeSlug()
    {
        $slug = THEME_HANDLE . '_';
        $slug .= str_replace(' ', '_', strtolower($this->pluralName));
        return strlen($slug) > 20 ? substr($slug, 0, 20) : $slug;
    }

    /**
     * Retrieves a meta value for the post type. Primarily for use with ACF.
     * Returns null if not found.
     *
     * @param int    $postId  The ID of the post
     * @param string $metaKey The key we are searching a value for
     * @return mixed|null
     * @since 1.0
     */
    public function getMeta($postId, $metaKey)
    {
        $meta = get_post_meta($postId, $metaKey, true);

        if (!isset($meta)) {
            return null;
        }

        return $meta;
    }

    /**
     * Registers the Post Type with WordPress based on
     * the defined variables
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    public function registerPostType()
    {
        register_post_type($this->getPostTypeSlug(),
            array(
                'labels' => array(
                    'name' => $this->singularName,
                    'singular_name' => $this->pluralName,
                    'menu_name' => $this->pluralName,
                    'add_new_item' => 'Add new ' . $this->singularName, // Displays at top of entry page.
                ),
                'public' => $this->public,
                'has_archive' => is_bool($this->hasArchive)
                    ? $this->hasArchive
                    : true,
                'exclude_from_search' => $this->excludeFromSearch,
                'publicly_queryable' => $this->publiclyQueryable,
                'show_in_nav_menus' => $this->showInNavMenus,
                'show_in_menu' => $this->showInMenu,
                'show_in_admin_bar' => $this->showInAdminBar,
                'hierarchical' => $this->hierarchical,
                'menu_icon' => $this->menuIcon,
                'capability_type' => $this->capabilityType,
                'supports' => $this->supports,
                'taxonomies' => $this->taxonomies,
                'rewrite' => array(
                    'slug' => is_bool($this->hasArchive)
                        ? sanitize_title_with_dashes($this->pluralName)
                        : sanitize_title_with_dashes($this->hasArchive),
                ),
            )
        );

        return $this;
    }
}