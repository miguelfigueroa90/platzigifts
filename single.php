<?php get_header(); ?>

<main class="container">
    <?php if(have_posts()) : ?>
        <?php while(have_posts()): ?>
            <?php the_post() ?>
            <h1 class="my-3"><?= the_title() ?></h1>
            <div class="row my-3">
                <div class="col-6">
                    <?php the_post_thumbnail() ?>
                </div>
                <div class="col-6">
                    <?php the_content() ?>
                </div>
            </div>
        <?php endwhile ?>
    <?php endif ?>
</main>

<?php get_footer(); ?>