<?php
/**
 * Header File
 *
 * @author Shane Smith <voodoogq@gmail.com>
 * @since 1.0
 */

?>
<!DOCTYPE html>
<html class="no-js" lang="en-us">
    <head>
        <!-- NOJS TOGGLE -->
        <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>

        <!-- META DATA -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php $faviconDir = get_template_directory_uri() . '/assets/media/favicon'?>
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $faviconDir; ?>/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $faviconDir; ?>/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $faviconDir; ?>/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $faviconDir; ?>/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $faviconDir; ?>/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $faviconDir; ?>/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $faviconDir; ?>/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $faviconDir; ?>/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $faviconDir; ?>/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $faviconDir; ?>/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $faviconDir; ?>/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $faviconDir; ?>/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $faviconDir; ?>/favicon-16x16.png">
        <link rel="manifest" href="<?php echo $faviconDir; ?>/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!--[if IE]><meta http-equiv="cleartype" content="on" /><![endif]-->

        <meta property="og:image" content="<?php echo get_template_directory_uri() ?>/assets/media/images/logo.png" />
        <meta property="og:title" content="<?php wp_title(); ?>" />

        <!-- SEO -->
        <title>
            <?php wp_title(); ?>
        </title>

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
