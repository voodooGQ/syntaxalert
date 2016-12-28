<?php
/**
 * Renders the Twig Template based on the controller supplied
 *
 * @author Shane Smith <ssmith@voodoogq.com>
 * @since 1.0
 */

namespace Wp\Vendor\Twig;

/**
 * Class Template
 *
 * Renders the Twig Template based on the Interface and Loader
 *
 * @package Wp\Vendor\Twig
 * @since   1.0
 */
class Template
{
    /**
     * The controller. Must implement TwigInterface
     *
     * @var TwigInterface
     * @since 1.0
     */
    private $controller;

    /**
     * The file name for the twig template
     *
     * @var string
     * @since 1.0
     */
    private $templateFile;

    /**
     * The array of Twig Data
     *
     * @var array
     * @since 1.0
     */
    private $twigData;

    /**
     * Constructor
     *
     * @param \Wp\Vendor\Twig\TwigInterface $controller
     * @since 1.0
     */
    public function __construct($controller)
    {
        $interfaces = class_implements($controller);

        try {
            if(!in_array('\Wp\Vendor\Twig\TwigInterface', $interfaces) == false) {
                throw new \Exception('FATAL ERROR: Controller ' . get_class($controller) . ' must implement \Wp\Vendor\Twig\TwigInterface');
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $this->controller = $controller;
        $this->templateFile = $controller->getTemplateName();
        $this->twigData = $controller->getTwigData();
    }

    /**
     * Render the template
     *
     * @return $this
     * @since 1.0
     */
    public function render()
    {
        if (isset($this->templateFile)) {
            $twig = new TwigLoader(
                $this->templateFile,
                $this->twigData
            );

            $twig->render();
        }
        return $this;
    }
}
