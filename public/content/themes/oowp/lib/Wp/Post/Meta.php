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
        $parsed = $parser->text(parent::getPostContent());
        
        return $stripped
            ? wp_strip_all_tags($this->stripCodeBlocks($parsed), true)
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
        return preg_replace('/<pre[^>]*>.*?<\/pre>/i', '', $content);
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
}
