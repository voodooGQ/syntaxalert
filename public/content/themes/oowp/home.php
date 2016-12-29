<?php
/**
 * Home (Blog Roll Template)
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

use Wp\Home\Controller;
use Wp\Vendor\Twig\Template;

get_header();
$template = new Template(new Controller());
$template->render();
get_footer();
