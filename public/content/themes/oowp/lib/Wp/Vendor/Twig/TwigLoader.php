<?php
/**
 * Handles the loading of Twig based templates
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since  1.0
 */

namespace Wp\Vendor\Twig;

/**
 * Handles the loading of Twig based templates
 *
 * @class   TwigLoader
 * @package Wp\Vendor\Twig
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class TwigLoader
{
    /**
     * The permission level to set the on the Twig Cache folder
     *
     * @const
     * @type int
     * @since 1.0
     */
    const TWIG_CACHE_FOLDER_PERMISSIONS = '0777';

    /**
     * The Twig Environment library
     *
     * @var null|\Twig_Environment
     * @since 1.0
     */
    private $twig = null;

    /**
     * The name of the template to look for
     *
     * @var null|string
     * @since 1.0
     */
    private $templateName = null;

    /**
     * The data array supplied by the user to pass to the template
     *
     * @var array
     * @since 1.0
     */
    private $data = array();

    /**
     * Constructor
     *
     * @param string $templateName The name of the Template file
     * @param array  $data         The array of data to pass to the Twig Template
     */
    public function __construct($templateName, $data = array())
    {
        $this->templateName = substr($templateName, -5, 5) == '.twig'
            ? $templateName
            : $templateName . '.twig';

        $this->data = $data;

        $this->init();
    }

    /**
     * Initialize.
     * Prepares the template for load.
     *
     * @return TwigLoader
     * @since 1.0
     * @chainable
     */
    public function init()
    {
        return $this->cacheFolderCheck()
            ->twigInit();
    }

    /**
     * Verifies the cache directory exists.
     * If not attempts to create it or shoots an error
     *
     * @return TwigLoader
     * @since 1.0
     */
    private function cacheFolderCheck()
    {
        $themePath      = get_template_directory() . '/';
        $twigCache      = TWIG_CACHE;

        if (!file_exists($themePath . $twigCache)) {
            try {
                $oldmask = umask(0);
                if (!mkdir($themePath . $twigCache, self::TWIG_CACHE_FOLDER_PERMISSIONS)) {
                    $errorMsg = 'ERROR: ' . __CLASS__ . ' cannot create the "' . $twigCache . '" ';
                    $errorMsg .= 'in the "' . $themePath . "' directory. ";
                    $errorMsg .= 'Please update the permissions in the theme folder temporarily or create a ';
                    $errorMsg .= '"' . $twigCache . '" folder and give it ';
                    $errorMsg .= self::TWIG_CACHE_FOLDER_PERMISSIONS . ' permissions';

                    throw new \Exception($errorMsg);
                }
                umask($oldmask);
            } catch (\Exception $e) {
                echo $e->getMessage();
                trigger_error("Fatal error", E_USER_ERROR);
            }

        }

        return $this;
    }

    /**
     * Handles the loading of the Twig filesystem
     *
     * @return TwigLoader
     * @since 1.0
     */
    private function twigInit()
    {
        $themePath      = get_template_directory() . '/';
        $twigCache      = TWIG_CACHE;
        $twigTemplate   = TWIG_TEMPLATE_DIR;

        $loader = new \Twig_Loader_Filesystem($themePath . $twigTemplate);

        $this->twig = new \Twig_Environment($loader, array(
            'cache' => $themePath . $twigCache,
            'auto_reload' => true,
            'debug' => true
        ));

        $this->twig->addExtension(new \Twig_Extension_Debug());

        return $this;
    }

    /**
     * Render the template based on the data supplied
     *
     * @return TwigLoader
     * @since 1.0
     * @chainable
     */
    public function render()
    {
        if ($this->twig != null) {
            $template = $this->twig->loadTemplate(
                $this->getTemplateName()
            );

            echo $template->render($this->data);
        }
        return $this;
    }

    /**
     * Returns the name of the template supplied to the loader
     *
     * @return null|string
     * @since 1.0
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * Returns the data array supplied to the loader
     *
     * @return array
     * @since 1.0
     */
    public function getData()
    {
        return $this->data;
    }
}