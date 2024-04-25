$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '#submitCheckOut', function () {
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
