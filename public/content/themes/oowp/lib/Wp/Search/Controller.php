<?php
/**
 * Search Page Controller
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Search;

use Wp\Vendor\Twig\TwigInterface;

/**
 * Class Controller
 *
 * @package Wp\Search\Controller
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
    const TWIG_TEMPLATE_NAME = 'template/search';

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
        $twigData['searchTerm'] = $meta->getSearchTerm();
        $twigData['posts']      = $meta->getPosts();
        return $twigData;
    }
}
