<?php
/**
 * Recipe Single Controller
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Recipe\Controller;

use Wp\Vendor\Twig\TwigInterface;
use Wp\Recipe\Meta\Single as Meta;
use Wp\Theme\Image as Image;

/**
 * Class Single
 *
 * @package Wp\Recipe\Controller;
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Single implements TwigInterface
{
    /**
     * The twig template name/location
     *
     * @const
     * @type string
     * @since 1.0
     */
    const TWIG_TEMPLATE_NAME = 'recipe/single';

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
     * @param int $postId
     * @return array
     * @since 1.0
     */
    public function getTwigData($postId = null)
    {
        global $post;
        $id = null;

        if(!empty($postId)) {
            $id = $postId;
        } else if($post) {
            $id = $post->ID;
        }

        $twigData = array();

        if($id) {
            $meta = new Meta($id);
            $imageMeta = Image::getImageMeta(get_post_thumbnail_id($id));
            $twigData['featured_image_src']         = $imageMeta['urls']['square'];
            $twigData['title']                      = $meta->getPostTitle();
            $twigData['permalink']                  = $meta->getPermalink();
            $twigData['content']                    = $meta->getPostContent();
            $twigData['ingredients']                = $meta->getIngredients();
            $twigData['instructions']               = $meta->getInstructions();
            $twigData['original_author']            = array(
                'name'  =>  $meta->getOriginalAuthor(),
                'url'   =>  $meta->getOriginalUrl()
            );
            $twigData['prep_time']                  = $meta->getPrepTime();
            $twigData['inactive_time']              = $meta->getInactiveTime();
            $twigData['cook_time']                  = $meta->getCookTime();
            $twigData['total_time']                 = $meta->getTotalTime();
            $twigData['yield']                      = $meta->getYield();

        }

        return $twigData;
    }
}