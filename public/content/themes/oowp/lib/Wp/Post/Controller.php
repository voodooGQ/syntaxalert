<?php
/**
 * Post Controller 
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Post;

use Wp\Vendor\Twig\TwigInterface;
use Wp\Theme\Image;

/**
 * Class Controller
 *
 * @package Wp\Post
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
    const TWIG_TEMPLATE_NAME = 'template/post.twig';

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
    public function getTwigData($postId = null)
    {
        $id = null; 
        global $post;

	   	if(!empty($postId)) {
       		$id = $postId;
        } else if($post) {
        	$id = $post->ID;
        }
        $twigData = array();

        if ($id) {
            $meta                   = new Meta($id);
            $twigData['title']      = $meta->getPostTitle();
            $twigData['permalink']  = $meta->getPermalink();
            $twigData['content']    = $meta->getPostContent();
			$twigData['excerpt']	= $meta->getExcerpt(300);
        }
        return $twigData;
    }
}
