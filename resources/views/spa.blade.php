<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type="text/javascript">

        function translate(label) {
            return label
        }


        $(document).ready(function () {

            /**
             * A function that takes a products array and renders its HTML
             */
            function renderList(products, page) {
                let html = '';
                switch (page) {
                    case 'all' :
                        html = translate('All Product');
                        break
                    case 'cart' :
                        html = translate('All Cart Product');
                        break
                    case 'admin' :
                        html = translate('All Products');
                        break
                }

                $.each(products, function (key, product) {

                    html += '<div class="container">';
                    html += '<div style="padding: 10px; vertical-align: middle;" class="item" >';
                    html += '<img style="height: 120px; width: 120px;" alt="img" src="{{ asset("storage/images") }}/' + product.img_link + '">';
                    html += '</div>';
                    html += '<div class="item">';
                    html += '<h3>' + translate('Title') + ': ' + product.title + '</h3>';
                    html += '<p>' + translate('Description') + ' : ' + product.description + '</p>';
                    html += '<p>' + translate('Price') + ' : ' + product.price + '</p>';
                    html += '</div>';
                    html += '<div class="item">';

                    switch (page) {
                        case 'all' :
                            html += '<a class="button" href="#' + product.id + '">' + translate('Add') + '</a>';
                            break
                        case 'cart' :
                            html += '<a class="button" href="#cart/' + product.id + '">' + translate('Remove') + '</a>';
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
                if (page === 'cart' && products.length > 0) {
                    html += '<form action="#">';
                    html += '<input id="name" type="text" name="name" placeholder="' + translate('Name') + '"><br> ';
                    html += '<div style="color:red;" id="costumerNameError" class="error"></div>';
                    html += '<input id="contact" type="text" name="contact" placeholder="' + translate('Contact Details') + '"><br> ';
                    html += '<div style="color:red;" id="costumerContactError" class="error"></div>';
                    html += '<input id="comment" type="text" name="comment" placeholder="' + translate('Comments') + '"><br> ';
                    html += '<div style="color:red;" id="costumerCommentError" class="error"></div>';
                    html += '<input id="submit" type="submit" name="checkout" value="Submit">';
                    html += '</form>';
                }
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#submit', function () {
                const x = $("form").serializeArray();

                let name = $("#name").val();
                let contact = $("#contact").val();
                let comment = $("#comment").val();

                $.ajax({
                    type: 'post',
                    url: '/checkOutCart',
                    dataType: 'json',
                    data: {
                        'customer_name': name,
                        'customer_contact': contact,
                        'customer_comment': comment
                    },
                    success: function () {
                        window.location.hash = "#";
                    },
                    error: function (response) {
                        const res = response.responseJSON.errors;
                        if (res.customer_name) {
                            $('#costumerNameError').text(res.customer_name);
                        }

                        if (res.customer_contact) {
                            $('#costumerContactError').text(res.customer_contact);
                        }

                        if (res.customer_comment) {
                            $('#costumerCommentError').text(res.customer_comment);
                        }
                    }
                });
            });
        });
    </script>
</head>
<body>
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
