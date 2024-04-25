function login() {
    let html = `<h1>${translate('Login')}</h1>
                <input placeholder="email" type="email" id="email" name="email">
                <br>
                <div style="color:red;" id="emailErrorMsg" class="error"></div>
                <br>
                <input placeholder=${translate('password')} type="password" name="password" id="password">
                <br>
                <div style="color:red;" id="passwordErrorMsg" class="error"></div>
                <br>
                <input id="submitLogin" type="submit" name="login" value=${translate('login')}>`;
    return html;
}
