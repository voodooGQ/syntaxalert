<?php
/**
 * Default Page Template Controller
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Page;

use Wp\Vendor\Twig\TwigInterface;
use Wp\Theme\Image;

/**
 * Class Controller
 *
 * @package Wp\Frontpage\Controller
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
    const TWIG_TEMPLATE_NAME = 'template/page.twig';

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
            $imageMeta = Image::getImageMeta(get_post_thumbnail_id($post->ID));

            $twigData['title']                      = $meta->getPostTitle();
            $twigData['featured_image_src']         = $imageMeta['urls']['hero'];
            $twigData['content']                    = $meta->getPostContent();
        }
        return $twigData;
    }
}