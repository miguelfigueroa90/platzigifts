<?php get_header(); ?>

<main class="container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : ?>
            <?php the_post() ?>
            <h1 class="my-3"><?= the_title() ?></h1>
            <?php the_content() ?>
        <?php endwhile ?>
    <?php endif ?>
</main>

<?php get_footer(); ?>