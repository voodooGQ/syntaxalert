<?php
/**
 * Database Query Handler
 *
 * @author Shane Smith <ssmith@nerdery.com>
 * @since 1.0
 */

namespace Wp\Search;

/**
 * Class Query
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since  1.0
 */
class Query
{
   /**
     * Returns a search query based on $_GET['s'] request
     *
     * @param string $searchTerm The term we're searching by
     * @param int $offset The number of posts to offset relative to max
     * @param int $max The maximum amount of posts to pull
     * @return null|\WP_Query
     * @since 1.0
     */
    public static function search($searchTerm, $offset, $max)
    {
        /** @var \WP_Query $wpdb */
        global $wpdb;

        $searchQuery = null;

        // If no search term supplied, send back empty query
        if(empty($searchTerm)) {
            return new \WP_Query();
        }

        $keyword = '%' . like_escape( $searchTerm ) . '%';

        // Search in all custom fields
        $metaPosts = $wpdb->get_col(
            $wpdb->prepare(
              "SELECT DISTINCT post_id FROM {$wpdb->postmeta}
              WHERE meta_value LIKE '%s'", $keyword )
        );

        // Search in post_title and post_content
        $standardPosts = $wpdb->get_col(
            $wpdb->prepare("SELECT DISTINCT ID FROM {$wpdb->posts}
                WHERE post_title LIKE '%s'
                OR post_content LIKE '%s'", $keyword, $keyword ) );

        // Merge the arrays
        $postIDs = array_merge( $standardPosts, $metaPosts );

        // Query arguments
        $args = array(
            'post_type'   => array(
                'post',
            ),
            'post_status' => 'publish',
            'post__in'    => $postIDs,
            'posts_per_page'    => ($offset == 0) ? -1 : $max,
            'offset'            => $offset,
        );

        $searchQuery = new \WP_Query(!empty($postIDs) ? $args : '');

        wp_reset_query();

        return $searchQuery;
    }
}
