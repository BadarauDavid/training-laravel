function translate(label) {
    return label
}


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
        html += '<img style="height: 120px; width: 120px;" alt="img" src="storage/images/'+ product.img_link + '">';
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
        html += '<input id="submitCheckOut" type="submit" name="checkout" value="Submit">';
        html += '</form>';
    }
    return html;
}
