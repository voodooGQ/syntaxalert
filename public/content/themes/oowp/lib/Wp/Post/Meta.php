<?php
/**
 * Post Template
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Post;

use Wp\Theme\MetaParent;
use Parsedown;

/**
 * Class Meta
 *
 * @package Wp\Post
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Meta extends MetaParent {

    /**
     * Get modified post content, markdown parsed
     *
     * @param boolean $stripped Strip HTML and markdown code blocks for excerpts
     * @since 1.0
     */
    public function getPostContent($stripped = false)
    {
        $unconverted = $stripped 
            ? $this->stripCodeBlocks(parent::getPostContent())
            : parent::getPostContent();
        
        $parser = new Parsedown();
        $parsed = $parser->text($unconverted);
        
        return $stripped
            ? wp_strip_all_tags($parsed, true)
            : $parsed;
    }

    /**
     * Strip all markdown code blocks, for use in excerpts
     *
     * @param string $content The content to strip
     * @return string
     * @since 1.0
     */
    public function stripCodeBlocks($content)
    {
        return preg_replace("/```[a-z]*\R.*?\R```/s", "", $content);
    }

    /**
     * Get excerpt for post.
     *
     * @param number $length The length of the excerpt
     * @return string
     * @since 1.0
     */
    public function getExcerpt($length)
    {
        return substr($this->getPostContent(true), 0, $length) . '...';
    }

    /**
     * Return the tags for the post
     *
     * @return array
     * @since 1.0
     */
    public function getTags()
    {
        $output = array();
        $tags = wp_get_post_tags($this->postID);
        foreach($tags as $tag) {
            $element = array(
                'id'    =>  $tag->term_id,
                'name'  =>  $tag->name,
                'slug'  =>  $tag->slug,
            );
            array_push($output, $element);
        }
        return $output;
    }
}