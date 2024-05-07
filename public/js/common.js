function translate(label) {
    return label
}

function escapeHtml(unsafe) {
    if (typeof unsafe !== 'string') {
        return unsafe;
    }

    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


function renderList(products, page) {
    let html = '';
    switch (page) {
        case 'all' :
            html = translate('Product');
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
        html += '<img style="height: 120px; width: 120px;" alt="img" src="storage/images/' + product.img_link + '">';
        html += '</div>';
        html += '<div class="item">';
        html += '<h3>' + translate('Title') + ': ' + product.title + '</h3>';
        html += '<p>' + translate('Description') + ' : ' + product.description + '</p>';
        html += '<p>' + translate('Price') + ' : ' + product.price + '</p>';
        html += '</div>';
        html += '<div class="item">';

        switch (page) {
            case 'all' :
                html += '<form id="addToCartForm">';
                html += '<input type="hidden" id="productId" name="productId" value="' + product.id + '">';
                html += '<input id="addToCart" type="submit" name="add" value="' + translate('Add') + '">';
                html += '</form>';
                break
            case 'cart' :
                html += '<form id="removeFromCartForm">';
                html += '<input type="hidden" id="productId" name="productId" value="' + product.id + '">';
                html += '<input id="removeFromCart" type="submit" name="remove" value="' + translate('Remove') + '">';
                html += '</form>';
                break
            case 'admin' :
                // html += '<a class="button" href="#products/' + product.id + '">' + translate('Delete') + ' </a>';
                html += '<form id="deleteProductForm">';
                html += '<input type="hidden" id="productId" name="productId" value="' + product.id + '">';
                html += '<input id="deleteProduct" type="submit" name="delete" value="' + translate('Delete') + '">';
                html += '</form>';

                html += '<a class="button" href="#product/' + product.id + '">' + translate('Edit') + '</a>';
                // html += '<form id="editProductForm">';
                // html += '<input type="hidden" id="productId" name="productId" value="' + product.id + '">';
                // html += '<input id="editProduct" type="submit" name="edit" value="' + translate('Edit') + '">';
                // html += '</form>';
                break
        }


        html += '</div>';
        html += '</div>';
    });
    if (page === 'cart' && products.length > 0) {
        html += '<form action="#">';
        html += '<input id="name" type="text" name="name" placeholder="' + translate('Name') + '"><br> ';
        html += '<div style="color:red;" id="costumerNameErrorMsg" class="error"></div>';
        html += '<input id="contact" type="text" name="contact" placeholder="' + translate('Contact Details') + '"><br> ';
        html += '<div style="color:red;" id="costumerContactErrorMsg" class="error"></div>';
        html += '<input id="comment" type="text" name="comment" placeholder="' + translate('Comments') + '"><br> ';
        html += '<div style="color:red;" id="costumerCommentErrorMsg" class="error"></div>';
        html += '<input id="submitCheckOut" type="submit" name="checkout" value="' + translate('Submit') + '">';
        html += '</form>';
    }
    return html;
}
