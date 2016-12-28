<?php
/**
 * Provides image related media functionality
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since  1.0
 */

namespace Wp\Theme;

/**
 * Provides image related media functionality
 *
 * @class   Image
 * @package Wp\Media
 */
class Image
{
    /**
     * Up-scales images prior to cropping through Media Upload
     *
     * @param $default
     * @param $orig_w
     * @param $orig_h
     * @param $dest_w
     * @param $dest_h
     * @param $crop
     * @return array|null
     * @since 1.0
     */
    public static function thumbnailUpscale($default, $orig_w, $orig_h, $dest_w, $dest_h, $crop)
    {
        if (!$crop) return null; // let the wordpress default function handle this
        $aspect_ratio = $orig_w / $orig_h;
        $size_ratio = max($dest_w / $orig_w, $dest_h / $orig_h);

        $crop_w = round($dest_w / $size_ratio);
        $crop_h = round($dest_h / $size_ratio);

        $s_x = floor(($orig_w - $crop_w) / 2);
        $s_y = floor(($orig_h - $crop_h) / 2);

        return array(0, 0, (int)$s_x, (int)$s_y, (int)$dest_w, (int)$dest_h, (int)$crop_w, (int)$crop_h);
    }

    /**
     * Returns image meta data based on the image ID supplied
     *
     * @param int $imageID The image post id
     * @return array
     * @since 1.0
     */
    public static function getImageMeta($imageID)
    {
        $meta = array();

        if (!wp_attachment_is_image($imageID)) {
            return $meta;
        }

        $imageSlugs = get_intermediate_image_sizes();
        $image = get_post($imageID);

        $meta['title'] = $image->post_title;
        $meta['caption'] = $image->post_excerpt;
        $meta['description'] = $image->post_content;
        $meta['alt'] = get_post_meta($image->ID, '_wp_attachment_image_alt', true);
        $meta['href'] = get_permalink($image->ID);
        $meta['src'] = $image->guid;
        $meta['file_upload_identifier'] = get_post_meta($imageID, 'file_upload_identifier', true);

        foreach ($imageSlugs as $slug) {
            $meta['sizes'][$slug] = array(
                'width' => wp_get_attachment_image_src($image->ID, $slug)[1],
                'height' => wp_get_attachment_image_src($image->ID, $slug)[2],
            );

            $meta['urls'][$slug] = wp_get_attachment_image_src($image->ID, $slug)[0];
        }

        return $meta;
    }
}