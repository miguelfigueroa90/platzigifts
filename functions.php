<?php

function init_template()
{
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
}

function assets()
{
    // Adding CSS Bootstrap and Montserrat font to the theme.
    wp_register_style(
        $handle='bootstrap',
        $src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css',
        $deps='',
        $ver='4.5.3',
        $media='all'
    );
    wp_register_style(
        $handle='montserrat',
        $src='https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap',
        $deps='',
        $ver='1.0',
        $media='all'
    );

    // Adding style to Style's queue.
    wp_enqueue_style(
        $handle='estilos',
        $src=get_stylesheet_uri(),
        $deps=['bootstrap', 'montserrat'],
        $ver='1.0',
        $media='all'
    );
}

// Hooks
add_action('after_setup_theme', 'init_template');
add_action('wp_enqueue_scripts', 'assets');