<?php
/**
 * Functions File.
 * Loads the PSR-4 Autoloader and the Primary Theme instantiation
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since  1.0
 */

require_once(get_template_directory() . '/lib/vendor/autoload.php');

// Primary Instantiation
$setup = \Wp\Theme\Setup::getInstance();