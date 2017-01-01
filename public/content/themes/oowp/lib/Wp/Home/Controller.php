<?php
/**
 * Homepage (Blog Roll) Controller 
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Home;

use Wp\Vendor\Twig\TwigInterface;
use Wp\Theme\Image;

/**
 * Class Controller
 *
 * @package Wp\Page
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
    const TWIG_TEMPLATE_NAME = 'template/home.twig';

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
        global $post;
        $twigData = array();
        
        if ($post) {
            $meta = new Meta($post->ID);
            $twigData['posts'] = $meta->getPosts();
        }
        return $twigData;
    }
}