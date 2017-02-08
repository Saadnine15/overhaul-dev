<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Product Customizer</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ secure_asset('assets/admin/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('assets/admin/css/style.css') }}" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Shopify -->
    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <!-- Angular JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>


    @yield('page_level_scripts_styles')

    <script src="{{ secure_asset('assets/admin/js/papaparse.min.js') }}"></script>
    <script src="{{ secure_asset('assets/admin/js/angular/app.js') }}"></script>

    <script type="text/javascript">
       ShopifyApp.init({
            apiKey: '{{ $api_key }}',
            shopOrigin: 'https://{{ $shop }}'
        });
    </script>


</head>

<body ng-app="product-updating-app">
<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}"/>
<div class="main-container">
    @yield('content')
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<!--<script src="{{ secure_asset('assets/admin/plugins/bootstrap/js/bootstrap.min.js') }}"></script>-->


</body>

</html>