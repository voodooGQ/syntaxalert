<?php
/**
 * Homepage (Blog Roll) Meta
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Tag\Meta;

use Wp\Theme\MetaParent;
use Wp\Post\Controller as Post;

/**
 * Class Archive
 *
 * @package Wp\Tag\Meta
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Archive extends MetaParent {
    /**
     * Retrieve blog posts
     *
     * return \WP_Query
     */
    public function getPosts() {
        $data = array();
        $tag = get_queried_object();
        $posts =  get_posts(array(
            'post_status'   => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy'  => 'post_tag',
                    'field'     => 'slug',
                    'terms'     => $tag->slug
                )
            )
        ));
        foreach($posts as $post) {
            $entity = new Post();
            array_push($data, $entity->getTwigData($post->ID));
        }
        return $data;
    }

    /**
     * Return the tag name for the current archive
     *
     * @return string
     * @since 1.0
     */
    public function getTagTitle() {
        return single_tag_title('', false);
    }

}
