function renderProductForm(product) {
    product = product || {};
    let html = `<h1>${translate('Product')}</h1>
                <input type="text" id="title" placeholder=${translate('Title')} value="${escapeHtml(product.title || '')}" >
                <br>
                <div style="color:red;" id="titleErrorMsg" class="error"></div>
                <br>
                <input type="text" id="description" placeholder=${translate('Description')} value="${escapeHtml(product.description || '')}"</input>
                <br>
                <div style="color:red;" id="descriptionErrorMsg" class="error"></div>
                <br>
                <input type="number" id="price" placeholder=${translate('Price')} value="${escapeHtml(product.price || '')}">
                <br>
                <div style="color:red;" id="priceErrorMsg" class="error"></div>
                <br>
                <input type="file" id="fileToUpload"">
                <br>
                <div style="color:red;" id="fileErrorMsg" class="error"></div>
                <br>
                <input type="hidden" id="productId" name="productId" value="${escapeHtml(product.id || '')}">
                <input id="submitProduct" type="submit" name="save" value="${translate('Save')}"> <br><br>`;
    return html;
}
