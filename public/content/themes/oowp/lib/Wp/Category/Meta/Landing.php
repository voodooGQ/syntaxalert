<?php
/**
 * Category Archive Meta
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

namespace Wp\Category\Meta;

use Wp\Theme\Image;
use Wp\Recipe\Query;
use Wp\Recipe\Controller\Single as Recipe;

/**
 * Class Meta
 *
 * @package Wp\Category\Meta
 * @author  Shane Smith <voodoogq@gmail.com>
 * @since   1.0
 */
class Landing {

    /**
     * The ID of the current Category
     *
     * @var int|null
     */
    var $categoryId = null;

    public function __construct($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * Get the Category Title
     *
     * @return string
     */
    public function getTitle()
    {
        return get_cat_name($this->categoryId);
    }

    /**
     * Return the recipes for the current category
     *
     * @return array
     */
    public function getRecipes()
    {
        $query = Query::recipeByCategory($this->categoryId);
        $recipes = array();

        foreach($query->posts as $post) {
            $recipe = new Recipe();
            array_push($recipes, $recipe->getTwigData($post->ID));
        }

        return $recipes;
    }
}