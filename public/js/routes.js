$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '#submitLogin', function (e) {
        e.preventDefault();
        let email = $("#email").val();
        let password = $("#password").val();

        $.ajax('/handleLogin', {
            type: 'post',
            dataType: 'json',
            data: {
                'email': email,
                'password': password,
            },
            success: function () {
                window.location.hash = "#products";
            },
            error: function (response) {
                const res = response.responseJSON.errors;
                if (res.email) {
                    $('#emailErrorMsg').text(res.email);
                }

                if (res.password) {
                    $('#passwordErrorMsg').text(res.password);
                }
            }
        });
    })

    $(document).on('click', '#submitCheckOut', function () {

        let name = $("#name").val();
        let contact = $("#contact").val();
        let comment = $("#comment").val();

        $.ajax('/checkOutCart', {
            type: 'post',
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

    window.onhashchange = function () {
        $('.page').hide();
        switch (window.location.hash) {

            case '#login':
                $('.login').show();
                $('.login .login-form').html(login())
                break;

            case '#logout':
                $.ajax('/logout', {
                    type: 'post',
                    dataType: 'json',
                    success: function () {
                        window.location.hash = '#';
                    }
                });
                break

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
                $.ajax('/addToCart?productId=' + window.location.hash.split('#')[1], {
                    dataType: 'json',
                    success: function () {
                        window.location.hash = "#";
                    }
                });
                break;

            case (window.location.hash.match(/#cart\/\d+/) || {}).input:
                $.ajax('/deleteFromCart?productId=' + window.location.hash.split('/')[1], {
                    dataType: 'json',
                    success: function (response) {
                        window.location.hash = "#cart";
                        console.log(response);
                    }
                });
                break;

            case '#products':
                $('.products').show();
                $.ajax('/products',{
                    dataType: 'json',
                    success: function (response) {
                        $('.products .list').html(renderList(response.data.products,'admin'));
                    },
                    error: function () {
                        window.location.hash = '#login';
                    }
                });
                break;

            case (window.location.hash.match(/#products\/\d+/) || {}).input:
                $.ajax('/deleteProduct?productId=' + window.location.hash.split('/')[1], {
                    dataType: 'json',
                    success: function (response) {
                        window.location.hash = "#products";
                        console.log(response);
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
