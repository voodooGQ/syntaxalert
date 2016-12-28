<?php
/**
 * Site Footer Controller
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Landmark\Controller;

use Wp\Vendor\Twig\TwigInterface;
use Wp\Landmark\Meta\Footer as Meta;

/**
 * Class Footer
 *
 * @package Wp\Landmark\Controller
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Footer implements TwigInterface
{
    /**
     * The Twig Template Name
     *
     * @const
     * @type string
     * @since 1.0
     */
    const TWIG_TEMPLATE_NAME = 'landmark/footer';

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

        $meta = new Meta($post->ID);
        $twigData['copyright'] = $meta->getCopyright();
        return $twigData;
    }
}