<?php
/**
 * Category Landing Controller
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Category\Controller;

use Wp\Vendor\Twig\TwigInterface;
use Wp\Category\Meta\Landing as Meta;

/**
 * Class Landing
 *
 * @package Wp\Category\Controller;
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Landing implements TwigInterface
{
    /**
     * The twig template name/location
     *
     * @const
     * @type string
     * @since 1.0
     */
    const TWIG_TEMPLATE_NAME = 'category/landing';

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
     * Returns the data for Twig
     *
     * @return array
     * @since 1.0
     */
    public function getTwigData()
    {
        $twigData = array();

        $category = get_category(
            get_query_var('cat')
        );
        $meta = new Meta($category->cat_ID);
        $twigData['title']      = $meta->getTitle();
        $twigData['recipes']    = $meta->getRecipes();

        return $twigData;
    }
}