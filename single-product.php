<?php get_header(); ?>

<main class="container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : ?>
            <?php the_post() ?>
            <?php $taxonomies = get_the_terms($post = get_the_ID(), $taxonomy = 'products-category') ?>
            <h1 class="my-3"><?= the_title() ?></h1>
            <div class="row my-3">
                <div class="col-6">
                    <?php the_post_thumbnail() ?>
                </div>
                <div class="col-6">
                    <?php the_content() ?>
                </div>
            </div>
            <?php
            $products = new WP_Query(
                $args = [
                    'post_type' => 'product',
                    'post_per_page' => 6,
                    'order' => 'ASC',
                    'order_by' => 'title',
                    'post__not_in' => [get_the_ID()],
                    'tax_query' => [
                        [
                            'taxonomy' => 'products-category',
                            'field' => 'slug',
                            'terms' => $taxonomies[0]->slug,
                        ],
                    ],
                ]
            )
            ?>
            <?php if ($products->have_posts()) : ?>
                <div class="row jutify-content-related-products">
                    <div class="col-12 text-center">
                        <h3>Related products</h3>
                    </div>
                    <?php while ($products->have_posts()) : ?>
                        <?php $products->the_post() ?>
                        <div class="col-2 my-3 text-center">
                            <?php the_post_thumbnail('post-thumbnail', ['class' => 'img-responsive img-thumbnail']) ?>
                            <h4>
                                <a href="<?= the_permalink() ?>">
                                    <?= the_title() ?>
                                </a>
                            </h4>
                        </div>
                    <?php endwhile ?>
                </div>
            <?php endif ?>
        <?php endwhile ?>
    <?php endif ?>
</main>

<?php get_footer(); ?>