<?php
/**
 * Returns an object populated with Post Meta based on ID
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since  1.0
 */

namespace Wp\Theme;

/**
 * Returns an object populated with Post Meta based on post ID
 *
 * @class   MetaParent
 * @package Wp\Theme
 * @since   1.0
 */
class MetaParent
{
    /**
     * The ID of the post where the meta is found
     *
     * @var null|int
     * @since 1.0
     */
    protected $postID = null;

    /**
     * The Post Title
     *
     * @var string|null
     * @since 1.0
     */
    protected $post_title = null;

    /**
     * The Post Type
     *
     * @var string|null
     * @since 1.0
     */
    protected $post_type = null;

    /**
     * The Permalink
     *
     * @var string|null
     * @since 1.0
     */
    protected $permalink = null;

    /**
     * The Post Content
     *
     * @var string|null
     * @since 1.0
     */
    protected $post_content = null;

    /**
     * The Featured Image ID
     *
     * @var int|null
     * @since 1.0
     */
    protected $featured_image_id = null;

    /**
     * Constructor
     *
     * @param int|object $postID The id of the post or the post object
     * @since 1.0
     */
    public function __construct($postID)
    {
        if (intval($postID)) {
            $this->postID = $postID;
        } elseif (is_object($postID) && isset($postID->ID)) {
            $this->postID = $postID->ID;
        } else {
            // Throw an error/warning?
            return;
        }

        $this->init();
    }

    /**
     * Initializer
     *
     * @return $this
     * @since 1.0
     */
    public function init()
    {
        return $this->setBaseMeta()
            ->parseMeta();
    }

    /**
     * Set the base meta fields
     *
     * @return $this
     * @since 1.0
     */
    private function setBaseMeta()
    {
        $this->post_title = get_the_title($this->postID);
        $this->permalink = get_permalink($this->postID);
        $this->post_content = do_shortcode(get_post_field('post_content', $this->postID));
        $this->post_type = get_post_type($this->postID);
        $this->featured_image_id = get_post_thumbnail_id($this->postID);
        return $this;
    }

    /**
     * Parses the meta of the given post.
     * Establishes the parameters of the object based
     * on these meta values in the array retrieved.
     *
     * @return $this
     * @since 1.0
     */
    private function parseMeta()
    {
        $meta = get_post_meta($this->postID);

        foreach ($meta as $key => $value) {
            if (substr($key, 0, 1) === "_") {
                continue;
            }

            $fieldObject = get_field_object($key, $this->postID);

            if (empty($fieldObject['key'])) {
                continue;
            }

            if ($fieldObject['class'] === 'repeater') {
                $value = $fieldObject['value'];
            } else if (is_array($value)) {
                $value = $value[0];
            }

            $this->$key = is_serialized($value)
                ? unserialize($value)
                : $value;
        }

        return $this;
    }

    /**
     * Get the Post Title;
     *
     * @return null|string
     * @since 1.0
     */
    public function getPostTitle()
    {
        return $this->post_title;
    }

    /**
     * Get the Permalink
     *
     * @return null|string
     * @since 1.0
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Get the Post Type
     *
     * @return string
     * @since 1.0
     */
    public function getPostType()
    {
        return $this->post_type;
    }

    /**
     * Get the Post Content;
     *
     * @return null|string
     * @since 1.0
     */
    public function getPostContent()
    {
        return wpautop($this->post_content);
    }

    /**
     * Get the Featured Image ID
     *
     * @return int|null
     * @since 1.0
     */
    public function getFeaturedImageID()
    {
        return $this->featured_image_id;
    }

    /**
     * Gets the unparsed meta field name.
     *
     * @param string $field Meta Field Name
     * @return mixed
     */
    protected function getMeta($field)
    {
        return isset($this->{$field})
            ? $this->{$field}
            : null;
    }

    /**
     * For parsing repeater fields with one item in the row.
     * Will not handle subfields needing further parsing/handling.
     *
     * @param string        $field      ACF name of the repeater field.
     * @param string|array  $subfield   ACF names of the subfield.
     * @return array
     * @since 1.0
     */
    protected function getArrayMeta($field, $subfield)
    {
        $items = (array) $this->getMeta($field);
        $dataArray = array();

        /**
         * If array of subfields, returns:
         * $dataArray = array(
         *      array(
         *          'ingredient_image' => 'something',
         *          'ingredient_text'  => 'something else'
         *      ),
         *      ...
         * );
         */
        if (is_array($subfield)) {
            $subfields = $subfield;
            foreach($items as $item) {
                $newItem = array();
                foreach($subfields as $subfield) {
                    if(isset($item[$subfield])) {
                        $newItem[$subfield] = $item[$subfield];
                    }
                }
                if (count($newItem)) {
                    array_push($dataArray, $newItem);
                }
            }
        }
        /**
         * If not an array of subfields, returns:
         * $dataArray = array(
         *      'cinnamon',
         *      'nutmeg',
         *      ...
         * );
         */
        else {
            foreach($items as $item) {
                if(isset($item[$subfield])) {
                    array_push($dataArray, $item[$subfield]);
                }
            }
        }

        return $dataArray;
    }

    /**
     * Handles ACF choices field. Strips out choice: from "choice:Label".
     *
     * @param string $field
     * @return array
     */
    protected function getChoicesMeta($field)
    {
        $items = (array) $this->getMeta($field);
        $dataArray = array();

        foreach($items as $item) {
            $label = preg_replace('#[^:]*:#', '', $item);
            $dataArray[] = $label;
        }

        return $dataArray;
    }

}
