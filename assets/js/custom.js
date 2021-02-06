(function ($) {
    $('#products-categories').change(function () {
        $.ajax({
            url: pg.ajaxurl,
            method: 'POST',
            data: {
                'action': 'pg_products_filter',
                'category': $(this).find(':selected').val()
            },
            beforeSend: function () {
                $('#products-result').html('Cargando...')
            },
            success: function (data) {
                let html = '';

                data.forEach(element => {
                    html += `<div class="col-4 my-3">
                        <figure>${element.image}</figure>
                        <h4 class="text-center my-2">
                            <a href="${element.link}">${element.title}</a>
                        </h4>
                    </div>`
                });

                $('#products-result').html(html);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $(document).ready(function () {
        $.ajax({
            url: pg.apiurl + 'posts/3',
            method: 'GET',
            beforeSend: function () {
                $('#posts-result').html('Cargando...')
            },
            success: function (data) {
                let html = '';

                data.forEach(element => {
                    html += `<div class="col-4 my-3">
                        <figure>${element.image}</figure>
                        <h4 class="text-center my-2">
                            <a href="${element.link}">${element.title}</a>
                        </h4>
                    </div>`
                });

                $('#posts-result').html(html);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
})(jQuery);