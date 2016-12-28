<?php
/**
 * Theme Setup File. Handles the base setup configurations for the theme.
 * Should only be instantiated a single time in the functions.php file
 *
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
namespace Wp\Theme;

use Wp\Recipe\Register as RecipeRegister;

/**
 * Theme Setup Class
 *
 * @class   Setup
 * @package Wp\Theme
 * @since   1.0
 */
class Setup
{
    /**
     * The singleton Instance
     *
     * @var Setup
     * @default null
     * @since   1.0
     */
    private static $instance = null;

    /**
     * Constructor
     *
     * @since 1.0
     */
    public function __construct()
    {
        // Call all WP Actions and Filters
        $this->actions()
            ->filters();
    }

    /**
     * Initialize the Theme Application
     *
     * @return $this
     * @since 1.0
     */
    public function init()
    {
        return $this->registerCustomPostTypes()
            ->registerSupportFeatures()
            ->registerOptionsPage()
            ->registerNavigationMenus()
            ->registerImageSizes()
            ->registerAdminConfiguration();
    }

    /**
     * Returns the singleton instance of the Theme.
     * This keeps the theme class from being instantiated
     * more than once.
     *
     * ex: $setup = \Wp\Theme\Setup::getInstance();
     *
     * @return $this
     * @since 1.0
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * All actions that need to be run on instantiation of the theme.
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    protected function actions()
    {
        add_action('after_setup_theme', array(&$this, 'init'));
        add_action('wp_enqueue_scripts', array(&$this, 'enqueueStyles'), 99);
        add_action('wp_enqueue_scripts', array(&$this, 'enqueueScripts'));
        return $this;
    }

    /**
     * All filters that need to be run on instantiation of the theme.
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    protected function filters()
    {
        add_filter('image_resize_dimensions', array(new Image(), 'thumbnailUpscale'), 10, 6);
        add_filter('wp_title', array(&$this, 'wpTitle'), 10, 2);
        return $this;
    }

    /**
     * Register the Custom Post Types with WordPress
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    protected function registerCustomPostTypes()
    {
        RecipeRegister::getInstance();
        return $this;
    }

    /**
     * Register the ACF Options Page
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    protected function registerOptionsPage()
    {
        if(function_exists('acf_add_options_page')) {
            acf_add_options_page();
        }
        return $this;
    }

    /**
     * Allows the theme to register support of a certain theme feature.
     *
     * @link  http://codex.wordpress.org/Function_Reference/add_theme_support
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    protected function registerSupportFeatures()
    {
        // Featured Images
        add_theme_support('post-thumbnails');
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        // Enable support for Post Formats.
        add_theme_support(
            'post-formats',
            array(
                'aside',
                'image',
                'video',
                'quote',
                'link'
            )
        );

        // Enable support for HTML5 markup.
        add_theme_support(
            'html5',
            array(
                'comment-list',
                'search-form',
                'comment-form',
                'gallery',
            )
        );

        return $this;
    }

    /**
     * Register all navigation menus with the theme
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    protected function registerNavigationMenus()
    {
        $themeHandle = THEME_HANDLE;

        register_nav_menus(
            array(
                'primary'       => __('Primary', $themeHandle),
            )
        );

        return $this;
    }

    /**
     * Register custom image sizes with the theme
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    protected function registerImageSizes()
    {
        add_image_size(
            'square',
            '600',
            '600',
            true
        );

        return $this;
    }

    /**
     * Registers the admin configuration at setup
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    protected function registerAdminConfiguration()
    {
        new Admin();
        return $this;
    }

    /**
     * Enqueue CSS Stylesheets.
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    public function enqueueStyles()
    {
        $themeHandle = THEME_HANDLE;
        $themeVersion = THEME_VERSION;
        $stylesFolder = get_template_directory_uri() . '/assets/styles/';

        wp_register_style(
            $themeHandle . '_screen',
            $stylesFolder .  'screen.css',
            array(),
            $themeVersion,
            'screen, projection'
        );

        wp_enqueue_style($themeHandle . '_screen');
        return $this;
    }

    /**
     * Enqueue JavaScript files
     *
     * @return $this
     * @since 1.0
     * @chainable
     */
    public function enqueueScripts()
    {
        $themeHandle = THEME_HANDLE;
        $themeVersion = THEME_VERSION;
        $scriptsFolder = get_template_directory_uri() . '/assets/scripts/';

        wp_register_script(
            $themeHandle . '_app',
            $scriptsFolder . 'app.js',
            array('jquery'),
            $themeVersion,
            true
        );

        // Localize data
        wp_localize_script(
            $themeHandle . '_app',
            'cms_settings',
            array(
                'ajaxUrl'       => admin_url('admin-ajax.php'),
                'themePath'     => get_template_directory_uri() . '/',
                'themeVersion'  => $themeVersion
            )
        );

        wp_enqueue_script($themeHandle . '_app');
        return $this;
    }

    /**
     * Filters wp_title to print a neat <title> tag based on what is being viewed.
     *
     * @param string $title Default title text for current view.
     * @param string $sep   Optional separator.
     * @return string The filtered title.
     * @since 1.0
     */
    public static function wpTitle($title, $sep = ' - ')
    {
        global $page, $paged;

        if (!is_front_page()) {
            $sep = ' - ';
        }

        if (is_feed()) {
            return $title;
        }

        // Add the blog name
        $title .= $sep . get_bloginfo('name', 'display');

        return $title;
    }
}
