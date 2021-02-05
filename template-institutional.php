<?php
// Template name: Institutional Page

get_header();
?>

<main class="container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : ?>
            <?php the_post() ?>
            <h1 class="my-3">
                <?php if (get_field('title')) : ?>
                    <?= the_field('title') ?>
                <?php else : ?>
                    <?= the_title() ?>
                <?php endif ?>
                <?php if (get_field('image')) : ?>
                    <img src="<?= get_field('image') ?>" alt="Institutional">
                <?php endif ?>
                <hr>
            </h1>
            <?php the_content() ?>
        <?php endwhile ?>
    <?php endif ?>
</main>

<?php get_footer(); ?>