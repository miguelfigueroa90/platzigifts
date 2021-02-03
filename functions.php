<?php

function init_template()
{
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
}

// Hooks
add_action('after_setup_theme', 'init_template');