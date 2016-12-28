<?php
/**
 * The Recipe Post Meta
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Recipe\Meta;

use Wp\Theme\MetaParent;

/**
 *
 * Class Single
 *
 * @package Wp\Recipe\Meta
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Single extends MetaParent {

    /**
     * Measurement conversion associations
     *
     * @const
     * @var array
     * @since 1.0
     */
    var $measurementConversions = array(
        'teaspoon'      => 'tsp.',
        'tablespoon'    => 'tbl.',
        'fluid_ounce'   => 'fl oz.',
        'gill'          => 'gill',
        'cup'           => 'cup',
        'pint'          => 'pint',
        'quart'         => 'quart',
        'gallon'        => 'gallon',
        'milliliter'    => 'ml.',
        'liter'         => 'liter',
        'deciliter'     => 'dl.',
        'pound'         => 'lb.',
        'ounce'         => 'oz.',
        'milligram'     => 'mg.',
        'gram'          => 'gram',
        'kilogram'      => 'kg',
        'millimeter'    => 'mm',
        'centimeter'    => 'cm',
        'meter'         => 'meter',
        'inch'          => 'inch',
        'foot'          => 'foot'
    );

    /**
     * Convert the name of the measurement to the display version and add a plural if appropriate
     *
     * @param number $quantity
     * @param string $measurement
     * @return mixed|string
     */
    protected function measurementConversion($quantity, $measurement) {
        $converted = $this->measurementConversions[$measurement];

        if($quantity > 1) {
            if($measurement == 'cup' || $measurement == 'pint' || $measurement == 'quart' || $measurement == 'gallon'
                || $measurement == 'liter' || $measurement == 'gram' || $measurement == 'meter' || $measurement == 'inch') {
                $converted = $converted . 's';
            }
        }

        return $converted;
    }

    /**
     * Quantity conversion from decimal to fraction (in specific measurement cases)
     *
     * @param number $quantity
     * @param string $measurement
     * @return null|string
     */
    protected function quantityConversion($quantity, $measurement)
    {
        if ($measurement == 'tablespoon' || $measurement == 'teaspoon' || $measurement == 'cup'
            || $measurement == 'gallon' || $measurement == 'liter' || $measurement == 'pound') {

            $whole = floor($quantity);
            $decimal = $quantity - $whole;
            $fraction = null;

            if ($decimal) {
                switch ($decimal) {
                    case 0.25:
                        $fraction = ' 1/4';
                        break;
                    case 0.5:
                        $fraction = ' 1/2';
                        break;
                    case 0.75:
                        $fraction = ' 3/4';
                        break;
                }
            }

            $quantity = ($whole > 0) ? $whole . $fraction : $fraction;
        }

        return $quantity;
    }

    /**
     * Convert a number of minutes into hour/minute string
     *
     * @param $minutes
     * @return string
     */
    protected function convertTime($minutes)
    {
        $converted      = $minutes / 60;
        $hours          = floor($converted);
        $actualMinutes  = $minutes % 60;
        $output = '';

        if($hours != 0) {
            $output .= $hours . ' hr ';
        }
        if($actualMinutes != 0) {
            $output .= $actualMinutes . ' min';
        }

        return trim($output);
    }

    /**
     * Return an array of ingredient sections and their ingredient lists
     *
     * @return array
     * @since 1.0
     */
    public function getIngredients()
    {
        $output = array();

        if(have_rows('ingredient_section')) {
            while(have_rows('ingredient_section')) { the_row();
                $section = array();
                $section['title'] = get_sub_field('ingredient_section_title');
                $section['ingredients'] = array();
                if(have_rows('ingredients')) {
                    while(have_rows('ingredients')) { the_row();
                        $ingredient = array();
                        $ingredient['quantity'] = $this->quantityConversion(
                            get_sub_field('quantity'),
                            get_sub_field('measurement')
                        );
                        $ingredient['range'] = $this->quantityConversion(
                            get_sub_field('range'),
                            get_sub_field('measurement')
                        );
                        $ingredient['measurement'] = $this->measurementConversion(
                            get_sub_field('quantity'),
                            get_sub_field('measurement')
                        );
                        $ingredient['ingredient'] = get_sub_field('ingredient');
                        array_push($section['ingredients'], $ingredient);
                    }
                }
                array_push($output, $section);
            }
        }

        return $output;
    }

    /**
     * Return an array of the recipe instruction sections
     *
     * @return array
     */
    public function getInstructions()
    {
        $output = array();

        if(have_rows('instruction_section')) {
            while(have_rows('instruction_section')) { the_row();
                $section = array();
                $section['title'] = get_sub_field('instruction_section_title');
                $section['instructions'] = get_sub_field('instructions');
                array_push($output, $section);
            }
        }

        return $output;
    }

    /**
     * Get the original author name
     *
     * @return string
     */
    public function getOriginalAuthor() {
        return $this->getMeta('original_author');
    }

    /**
     * Get the original url for the recipe
     *
     * @return string
     */
    public function getOriginalUrl() {
        return $this->getMeta('original_url');
    }

    /**
     * Return the Prep time in hours/minutes
     *
     * @return string
     */
    public function getPrepTime()
    {
        return $this->convertTime(
            $this->getMeta('prep_time')
        );
    }

    /**
     * Return the Cook time in hours/minutes
     *
     * @return string
     */
    public function getCookTime()
    {
        return $this->convertTime(
            $this->getMeta('cook_time')
        );
    }

    /**
     * Return the inactive time in hours/minutes
     *
     * @return string
     */
    public function getInactiveTime()
    {
        return $this->convertTime(
            $this->getMeta('inactive_time')
        );
    }

    /**
     * Retrieve the total time based on prep/inactive/cook times
     *
     * @return string
     */
    public function getTotalTime()
    {
        $totalTime = $this->getMeta('prep_time') + $this->getMeta('inactive_time') + $this->getMeta('cook_time');
        return $this->convertTime($totalTime);
    }

    /**
     * Return the recipe yield
     *
     * @return string
     */
    public function getYield()
    {
        return $this->getMeta('yield');
    }
}
