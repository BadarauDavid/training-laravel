function renderOrders(orders) {
    let html = `<h1> ${translate('All orders')} </h1>`;
    html += `
<!--                <form id="goToOrderForm" ">-->
<!--                <input type="hidden" id="orderId" name="orderId" value="${order.order_id}">-->
<!--                <input id="goToOrder" type="submit" name="go" value="${__('Go to Order')}">-->
<!--                </form>-->
                <h4># <a href="#order/${order.order_id}">${order.order_id}</a></h4>
                <h4>${translate('Total Price')} : ${order.total_price}</h4>
                <h4>${translate('Summary')} : ${order.product_titles}</h4>
                <h4>${translate('Data')} : ${order.order_created_at}</h4>
                <hr>
        `;
    $.each(orders, function (key, order) {
    });
    return html;
}
