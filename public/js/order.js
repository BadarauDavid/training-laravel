function renderOrder(order) {
    let html = `<h1>${translate('Order number')} #${order.id} </h1>`;
    $.each(order.products, function (key, product) {
        html += `<div class="container">
                    <div class="item">
                    <img style="height: 120px; width: 120px;" alt="img" src="storage/images/${product.img_link} ">
                    </div>
                    <div class="item">
                    <h3>${translate('Title')}: ${product.title}</h3>
                    <p>${translate('Description')}: ${product.description}</p>
                    <p>${translate('Price')}: ${product.price}</p>
                    </div>
                 </div>`;
    });
    html += `<br>
             <h3>${translate('Customer Name')}: ${order.customer_name}</h3>
             <p>${translate('Customer Contact')}: ${order.customer_contact}</p>
             <p>${translate('Customer Comment')}: ${order.customer_comment}</p>`;
    return html;
}
