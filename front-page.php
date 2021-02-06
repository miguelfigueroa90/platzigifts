<?php get_header(); ?>

<main class="container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : ?>
            <?php the_post() ?>
            <h1 class="my-3"><?= the_title() ?>!!</h1>
            <?php the_content() ?>
        <?php endwhile ?>
    <?php endif ?>

    <div class="products-list my-5">
        <h2 class="text-center">Products</h2>
        <div class="row my-3">
            <div class="col-12">
                <select name="products-categories" id="products-categories" class="form-control">
                    <option value="">All Categories</option>
                    <?php $terms = get_terms('products-category', ['hide_empty' => true]); ?>
                    <?php foreach ($terms as $term) : ?>
                        <option value="<?= $term->slug ?>"><?= $term->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div id="products-result" class="row justify-content">
            <?php
            $products = new WP_Query(
                $args = [
                    'post_type' => 'product',
                    'post_per_page' => -1, // -1 means all posts.
                    'order' => 'ASC',
                    'order_by' => 'title',
                ]
            );
            ?>
            <?php if ($products->have_posts()) : ?>
                <?php while ($products->have_posts()) : ?>
                    <?php $products->the_post() ?>
                    <div class="col-4">
                        <figure>
                            <?php the_post_thumbnail('post-thumbnail', ['class' => 'img-responsive img-thumbnail']) ?>
                        </figure>
                        <h4 class="my-3 text-center">
                            <a href="<?= the_permalink() ?>">
                                <?= the_title() ?>
                            </a>
                        </h4>
                    </div>
                <?php endwhile ?>
            <?php endif ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h1>News</h1>
        </div>
        <div class="row" id="posts-result">

        </div>
    </div>
</main>

<?php get_footer(); ?>