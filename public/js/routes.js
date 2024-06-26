$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).on('click', '#submitProduct', function (e) {
        e.preventDefault();
        let productId = window.location.hash.split('/')[1];
        let id = productId ? productId : 0;
        let formData = new FormData();
        formData.append('title', $("#title").val());
        formData.append('description', $("#description").val());
        formData.append('price', $("#price").val());
        formData.append('img_link', $('#fileToUpload')[0].files[0]);

        $.ajax('handleProduct?id=' + id, {
            type: 'post',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                // window.location.reload();
                window.location.hash = "#products";
            },
            error: function (response) {
                const res = response.responseJSON.errors;
                if (res) {
                    if (res.title) {
                        $('#titleErrorMsg').text(res.title);
                    }

                    if (res.description) {
                        $('#descriptionErrorMsg').text(res.description);
                    }

                    if (res.price) {
                        $('#priceErrorMsg').text(res.price);
                    }

                    if (res.img_link) {
                        $('#fileErrorMsg').text(res.img_link);
                    }
                }
            }
        });
    })

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
                if (res) {
                    if (res.email) {
                        $('#emailErrorMsg').text(res.email);
                    }

                    if (res.password) {
                        $('#passwordErrorMsg').text(res.password);
                    }
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
                if (res) {
                    if (res.customer_name) {
                        $('#costumerNameErrorMsg').text(res.customer_name);
                    }

                    if (res.customer_contact) {
                        $('#costumerContactErrorMsg').text(res.customer_contact);
                    }

                    if (res.customer_comment) {
                        $('#costumerCommentErrorMsg').text(res.customer_comment);
                    }
                }
            }
        });
    });

    $(document).on('click', '#addToCart', function () {
        let productId = $("#productId").val();
        $.ajax('/addToCart?productId=' + productId, {
            dataType: 'json',
            success: function () {
                window.location.reload();
            }
        });
    });

    $(document).on('click', '#removeFromCart', function () {
        let productId = $("#productId").val();
        $.ajax('/deleteFromCart?productId=' + productId, {
            dataType: 'json',
            success: function () {
                window.location.reload();
            }
        });
    });

    $(document).on('click', '#deleteProduct', function () {
        let productId = $("#productId").val();
        $.ajax('/deleteProduct?productId=' + productId, {
            dataType: 'json',
            type: 'post',
            success: function () {
                window.location.reload();
            }
        });
    });

    // $(document).on('click', '#editProduct', function () {
    //     let productId = $("#productId").val();
    //     $('.page').hide();
    //     $('.product').show();
    //     $.ajax({
    //         type: 'get',
    //         url: '/product?productId=' + productId,
    //         dataType: 'json',
    //         success: function (product) {
    //             $('.product .product-form').html(renderProductForm(product.data.product));
    //         },
    //         error: function () {
    //             window.location.hash = '#login';
    //         }
    //     });
    // });

    // $(document).on('click', '#goToOrder', function () {
    //     let orderId = $("#orderId").val();
    //     $('.page').hide();
    //     $('.order').show();
    //     $.ajax('/order?productId=' + orderId, {
    //         dataType: 'json',
    //         success: function (response) {
    //             $('.order .list').html(renderOrder(response.data.order));
    //         },
    //         error: function () {
    //             window.location.hash = '#login';
    //         }
    //     });
    //
    // });

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

            case '#products':
                $('.products').show();
                $.ajax('/products', {
                    dataType: 'json',
                    success: function (response) {
                        $('.products .list').html(renderList(response.data.products, 'admin'));
                    },
                    error: function () {
                        window.location.hash = '#login';
                    }
                });
                break;

            case '#product':
                $('.product').show();
                $('.product .product-form').html(renderProductForm());
                break;

            case (window.location.hash.match(/#product\/\d+/) || {}).input:
                $('.product').show();
                $.ajax({
                    type: 'get',
                    url: '/product?productId=' + window.location.hash.split('/')[1],
                    dataType: 'json',
                    success: function (product) {
                        $('.product .product-form').html(renderProductForm(product.data.product));
                    },
                    error: function () {
                        window.location.hash = '#login';
                    }
                });
                break;

            case '#orders':
                $('.orders').show();
                $.ajax('/orders', {
                    dataType: 'json',
                    success: function (response) {
                        $('.orders .list').html(renderOrders(response.data.orders));
                    },
                    error: function () {
                        window.location.hash = '#login';
                    }
                });
                break;

            case (window.location.hash.match(/#order\/\d+/) || {}).input:
                $('.order').show();
                $.ajax('/order?productId=' + window.location.hash.split('/')[1], {
                    dataType: 'json',
                    success: function (response) {
                        $('.order .list').html(renderOrder(response.data.order));
                    },
                    error: function () {
                        window.location.hash = '#login';
                    }
                });
                break;

            default:
                $.ajax('/index', {
                    dataType: 'json',
                    success: function (response) {
                        $('.index .list').html(renderList(response.data.products, 'all'));
                    }
                });

                $('.index').show();
                break;
        }
    }
    window.onhashchange();
});
