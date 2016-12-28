<?php
/**
 * Interface for Twig based data retrieval
 * Use with data controllers that utilize Twig for views.
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since  1.0
 */

namespace Wp\Vendor\Twig;

/**
 * Interface for Twig based data retrieval
 * Use with data controllers that utilize Twig for views.
 *
 * @package Wp\Vendor\Twig
 * @since   1.0
 */
interface TwigInterface
{
    /**
     * Returns the Twig template name
     *
     * @return string
     * @since 1.0
     */
    public function getTemplateName();

    /**
     * Returns the data array for Twig
     *
     * @return array
     * @since 1.0
     */
    public function getTwigData();
}