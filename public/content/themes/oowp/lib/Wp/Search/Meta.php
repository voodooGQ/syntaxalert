<?php
/**
 * Search Template Meta
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Search;

/**
 * Class Meta
 *
 * @package Wp\Search
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Meta 
{
    
    /**
     * Return the current search term
     *
     * @return string
     * @since 1.0
     */
    public function getSearchTerm()
    {
        return isset($_GET['s']) ? sanitize_text_field($_GET['s']) : null;
    }

    /**
     * Return the posts searched for
     *
     * @return array
     * @since 1.0
     */
    public function getPosts()
    {
        $searchTerm = '';
        $output = array();
        // Return early if there's no search term
        if($this->getSearchTerm() === null) { return $posts; }

        $query = Query::search($searchTerm, 0, -1);
        $posts = $query->posts;

        if(!empty($posts) && $posts != null) {
            foreach ($posts as $post) {
                var_dump($post->ID);
                $output = $post->ID;
                //$entry['title']     = $post->post_title;
                //$entry['excerpt']   = $post->post_excerpt;
                //$entry['url']       = get_permalink($post->ID);
                array_push($output, $entry);
            }
        }
    }
}

