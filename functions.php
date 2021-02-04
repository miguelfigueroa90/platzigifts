<?php

function init_template()
{
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    register_nav_menus($locations = ['top_menu' => 'Main menu']);
}

function assets()
{
    // Registering Bootstrap and Montserrat font styles.
    wp_register_style(
        $handle = 'bootstrap',
        $src = 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css',
        $deps = '',
        $ver = '4.5.3',
        $media = 'all'
    );
    wp_register_style(
        $handle = 'montserrat',
        $src = 'https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap',
        $deps = '',
        $ver = '1.0',
        $media = 'all'
    );

    // Adding style to Style's queue.
    wp_enqueue_style(
        $handle = 'custom_styles',
        $src = get_stylesheet_uri(),
        $deps = ['bootstrap', 'montserrat'],
        $ver = '1.0',
        $media = 'all'
    );

    // Adding script to script's queue.
    wp_enqueue_script(
        $handle = 'bootstrap',
        $src = 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js',
        $deps = ['jquery'],
        $ver = '4.5.3',
        $in_footer = true
    );
    wp_enqueue_script(
        $handle = 'custom',
        $src = get_template_directory_uri() . '/assets/js/custom.js',
        $deps = '',
        $ver = '1.0',
        $in_footer = true
    );
}

function sidebar()
{
    register_sidebar(
        $args = [
            'name' => 'Footer',
            'id' => 'footer',
            'description' => 'Footer\'s widget zone.',
            'before_tile' => '<p>',
            'after_tile' => '</p>',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
        ]
    );
}

function products_type()
{
    register_post_type(
        $post_type='product',
        $args=[
            'label' => 'Products',
            'description' => 'Platzi products',
            'labels' => [
                'name' => 'Products',
                'singular_name' => 'Product',
                'menu_name' => 'Products'
            ],
            'supports' => [
                'title',
                'editor',
                'thumbnail',
                'revisions'
            ],
            'public' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-cart',
            'can_export' => true,
            'publicly_queryable' => true,
            'rewrite' => true,
            'show_in_rest' => true,
        ]
    );
}

// Hooks
add_action('after_setup_theme', 'init_template');
add_action('wp_enqueue_scripts', 'assets');
add_action('widgets_init', 'sidebar');
add_action('init', 'products_type');
