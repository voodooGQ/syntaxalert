<?php
/**
 * Recipe Data Query
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Recipe;

/**
 * Class Query
 *
 * @package Wp\Recipe\Meta
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Query {
    /**
     * Get all Recipes
     *
     * @return \WP_Query
     * @since 1.0.1
     */
    public static function allRecipes()
    {
        $recipe = Register::getInstance();

        $query = new \WP_Query(array(
            'post_type'         => $recipe->getPostTypeSlug(),
            'post_status'       => array('publish'),
            'posts_per_page'    => -1,
            'order'             => 'date',
        ));

        wp_reset_query();

        return $query;
    }

    /**
     * Return all recipes by category
     *
     * @param integer $categoryId
     * @return \WP_Query
     */
    public static function recipeByCategory($categoryId)
    {
        $recipe = Register::getInstance();

        $query = new \WP_Query(array(
            'post_type'         => $recipe->getPostTypeSlug(),
            'post_status'       => array('publish'),
            'posts_per_page'    => -1,
            'order'             => 'DESC',
            'cat'               => $categoryId
        ));

        wp_reset_query();

        return $query;
    }

    /**
     * Return a random recipe by category
     *
     * @param integer $categoryId
     * @return \WP_Query
     */
    public static function randomRecipeByCategory($categoryId)
    {
        $recipe = Register::getInstance();

        $query = new \WP_Query(array(
            'post_type'         => $recipe->getPostTypeSlug(),
            'post_status'       => array('publish'),
            'posts_per_page'    => 1,
            'orderby'          => 'rand',
            'cat'               => $categoryId
        ));

        wp_reset_query();

        return $query;
    }
}