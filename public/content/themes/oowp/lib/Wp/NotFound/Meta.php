<?php
/**
 * 404 Meta
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\NotFound;

use Wp\Theme\MetaParent;

/**
 * Class Meta
 *
 * @package Wp\404
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Meta {
    /**
     * Return the error page image
     *
     * @return string
     * @since 1.0
     */
    public function get404Image() {
        return get_template_directory_uri() . '/assets/media/images/404.png';
    }
}
