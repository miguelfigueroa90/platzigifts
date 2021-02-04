<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head()  ?>
</head>

<body>
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-4">
                    <img src="<?= get_template_directory_uri() . '/assets/img/logo.png' ?>" alt="Logo">
                </div>
                <div class="col-8">
                    <nav>
                        <?= wp_nav_menu(
                            $args=[
                                'theme_location' => 'top_menu',
                                'menu_class' => 'main-menu',
                                'container_class' => 'container-menu',
                            ]) ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>