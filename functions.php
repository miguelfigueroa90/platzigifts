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

    wp_localize_script(
        $handle = 'custom',
        $object_name = 'pg',
        $l10n = [
            'ajaxurl' => admin_url($path = 'admin-ajax.php'),
            'apiurl' => home_url($path = 'wp-json/pg/v1/')
        ]
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
        $post_type = 'product',
        $args = [
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

function products_category_taxonomy()
{
    register_taxonomy(
        $taxonomy = 'products-category',
        $object_type = 'product',
        $args = [
            'hierarchical' => true,
            'labels' => [
                'name' => 'Products categories',
                'singular_name' => 'Products category',
            ],
            'show_in_nav_menu' => true,
            'show_admin_column' => true,
            'rewrite' => [
                'slug' => 'products-category',
            ],
        ]
    );
}

function pg_products_filter()
{
    $args = [
        'post_type' => 'product',
        'post_per_page' => -1,
        'order' => 'ASC',
        'order_by' => 'title',
    ];

    if ($_POST['category']) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'products-category',
                'field' => 'slug',
                'terms' => $_POST['category'],
            ],
        ];
    }

    $products = new WP_Query($args);

    if ($products->have_posts()) {
        $data = [];

        while ($products->have_posts()) {
            $products->the_post();

            $data[] = [
                'image' => get_the_post_thumbnail($post = get_the_ID(), $size = 'post-large', $attr = ['class' => 'img-responsive img-thumbnail']),
                'link' => get_the_permalink(),
                'title' => get_the_title(),
            ];
        }

        wp_send_json($data);
    }
}

function posts_api()
{
    register_rest_route(
        $namespace = 'pg/v1',
        $route = '/posts/(?P<quantity>\d+)',
        $args = [
            'methods' => 'GET',
            'callback' => 'posts_api_request',
        ],
        $override = false
    );
}

function posts_api_request($params)
{
    $args = [
        'post_type' => 'post',
        'post_per_page' => $params['quantity'],
        'order' => 'ASC',
        'order_by' => 'title',
    ];

    $posts = new WP_Query($args);

    if ($posts->have_posts()) {
        $data = [];

        while ($posts->have_posts()) {
            $posts->the_post();

            $data[] = [
                'image' => get_the_post_thumbnail($post = get_the_ID(), $size = 'post-large', $attr = ['class' => 'img-responsive img-thumbnail']),
                'link' => get_the_permalink(),
                'title' => get_the_title(),
            ];
        }

        return $data;
    }
}

function pg_register_block()
{
    $assets = include_once get_template_directory() . '/blocks/build/index.asset.php';

    wp_register_script(
        $handle = 'pg-block',
        $src = get_template_directory_uri() . '/blocks/build/index.js',
        $deps = $assets['dependencies'],
        $ver = $assets['version'],
        $in_footer = true
    );

    register_block_type(
        $name = 'pg/basic',
        $args = ['editor_script' => 'pg-block']
    );
}

// Hooks
add_action('after_setup_theme', 'init_template');
add_action('wp_enqueue_scripts', 'assets');
add_action('widgets_init', 'sidebar');
add_action('init', 'products_type');
add_action('init', 'products_category_taxonomy');
add_action('wp_ajax_pg_products_filter', 'pg_products_filter');
add_action('wp_ajax_nopriv_pg_products_filter', 'pg_products_filter');
add_action('rest_api_init', 'posts_api');
add_action('init', 'pg_register_block');
