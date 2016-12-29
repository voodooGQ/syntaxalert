<?php
/**
 * Homepage (Blog Roll) Meta
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Home;

use Wp\Theme\MetaParent;
use Wp\Post\Controller as Post;

/**
 * Class Meta
 *
 * @package Wp\Home
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Meta extends MetaParent {
    /**
     * Retrieve blog posts
     *
     * return \WP_Query
     */
    public function getPosts() {
        $data = array();
        $posts =  get_posts(array(
            'post_status' => 'publish',
        ));

        foreach($posts as $post) {
            $entity = new Post($post->ID);
            array_push($data, $entity->getTwigData());
        }

        return $data;
    }
}
