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
    public function getPostContent()
    {
        $unconverted = parent::getPostContent();
        $parser = new Parsedown();
        return $parser->text($unconverted);
    }
}
