<?php
/**
 * Site Footer Partial
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

use Wp\Landmark\Controller\Footer;
use Wp\Vendor\Twig\Template;

$controller = new Footer();
$template = new Template($controller);
$template->render();