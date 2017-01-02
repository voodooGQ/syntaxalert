<?php
/**
 * 404 Controller 
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\NotFound;

use Wp\Vendor\Twig\TwigInterface;

/**
 * Class Controller
 *
 * @package Wp\404
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Controller implements TwigInterface
{
    /**
     * The Twig Template Name
     *
     * @const
     * @type string
     * @since 1.0
     */
    const TWIG_TEMPLATE_NAME = 'template/404.twig';

    /**
     * Returns the name of the Twig Template to use
     *
     * @return string
     * @since 1.0
     */
    public function getTemplateName()
    {
        return self::TWIG_TEMPLATE_NAME;
    }

    /**
     * Returns the staff feed data for Twig
     *
     * @return array
     * @since 1.0
     */
    public function getTwigData()
    {
        $twigData = array();
        $meta = new Meta();
        $twigData['image']  = $meta->get404Image();
        return $twigData;
    }
}
