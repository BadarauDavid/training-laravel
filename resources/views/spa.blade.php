<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

</head>
<body>

<div class="page index">
    <!-- The index element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the cart by changing the hash -->
    <a href="#cart" class="button">Go to cart</a>
</div>

<!-- The cart page -->
<div class="page cart">
    <!-- The cart element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">Go to index</a>
</div>

<!-- The products page -->
<div class="page products">
    <!-- The cart element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">Go to index</a>
</div>

<!-- The login page -->
<div class="page login">
    <form class="login-form"></form>
</div>

</body>
<script type="text/javascript" rel="javascript" src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript" rel="javascript" src="{{ asset('js/routes.js') }}"></script>
<script type="text/javascript" rel="javascript" src="{{ asset('js/login.js') }}"></script>

</html>
