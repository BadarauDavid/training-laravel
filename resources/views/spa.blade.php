<html>
<head>

    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Custom JS script -->
    <script type="text/javascript">
        $(document).ready(function () {

            /**
             * A function that takes a products array and renders its HTML
             */
            function renderList(products, page) {
                let html = '';
                switch (page) {
                    case 'all' :
                        html = 'All Product';
                        break
                    case 'cart' :
                        html = 'All Cart Product';
                        break
                    case 'admin' :
                        html = 'All Products';
                        break
                }


                $.each(products, function (key, product) {

                    html += '<div class="container">';
                    html += '<div style="padding: 10px; vertical-align: middle;" class="item" >';
                    html += '<img style="height: 120px; width: 120px;" alt="img" src="{{ asset("storage/images") }}/' + product.img_link + '">';
                    html += '</div>';
                    html += '<div class="item">';
                    html += '<h3>Title: ' + product.title + '</h3>';
                    html += '<p>Description: ' + product.description + '</p>';
                    html += '<p>Price: ' + product.price + '</p>';
                    html += '</div>';
                    html += '<div class="item">';

                    switch (page) {
                        case 'all' :
                            html += '<a class="button" href="#' + product.id + '">Add</a>';
                            break
                        case 'cart' :
                            html += '<a class="button" href="#cart/' + product.id + '">Remove</a>';
                            break
                        //TO-DO
                        // case 'admin' :
                        //     html += '<a class="button" href="#index/' + product.id + '">Add</a>';
                        //     html += '<a class="button" href="# + product.id '">Add</a>';
                        //     break
                    }


                    html += '</div>';
                    html += '</div>';
                });

                return html;
            }

            /**
             * URL hash change handler
             */
            window.onhashchange = function () {
                $('.page').hide();
                switch (window.location.hash) {

                    case '#cart':
                        $('.cart').show();
                        $.ajax('/cart', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.cart .list').html(renderList(response.data.products, 'cart'));
                            }
                        });
                        break;

                    case (window.location.hash.match(/#\d+/) || {}).input:
                        productId = window.location.hash.split('#')[1];


                        // Show the cart page
                        $('.index').show();
                        $.ajax('/addToCart?productId=' + productId, {
                            dataType: 'json',
                            success: function () {
                                window.location.hash = "#";
                            }
                        });
                        break;

                    case (window.location.hash.match(/#cart\/\d+/) || {}).input:
                        productId = window.location.hash.split('/')[1];
                        console.log('/deleteFromCart?productId=' + productId);
                        // Show the cart page
                        $('.index').show();
                        $.ajax('/deleteFromCart?productId=' + productId, {
                            dataType: 'json',
                            success: function (respnse) {
                                window.location.hash = "#cart";
                                console.log(respnse);
                            }
                        });
                        break;

                    default:
                        $.ajax('/index', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the index list
                                $('.index .list').html(renderList(response.data.products, 'all'));
                            }
                        });

                        $('.index').show();
                        break;
                }
            }
            window.onhashchange();

        });
    </script>
</head>
<body>
<!-- The index page -->
<div class="page index">
    <!-- The index element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the cart by changing the hash -->
    <a href="#cart" class="button">Go to cart</a>
</div>

<!-- The cart page -->
<div class="page cart">
    <!-- The cart element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">Go to index</a>
</div>
</body>
</html>
