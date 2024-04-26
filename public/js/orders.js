function renderOrders(orders) {
    let html = `<h1> ${translate('All orders')} </h1>`;
    $.each(orders, function (key, order) {
        html += `
                <h4># <a href="#order?productId=${order.order_id}">${order.order_id}</a></h4>
                <h4>${translate('Total Price')} : ${order.total_price}</h4>
                <h4>${translate('Summary')} : ${order.product_titles}</h4>
                <h4>${translate('Data')} : ${order.order_created_at}</h4>
                <hr>
        `;
    });
    return html;
}
