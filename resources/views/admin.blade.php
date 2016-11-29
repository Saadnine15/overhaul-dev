@extends('layouts.main')

@section('content')

    <style>
        .white-block{
            padding: 15px 25px;
            background: #fff;
        }
        .white-block>h3{
            text-align: center;
            margin-bottom: 30px;
            color: #0078bd;
        }
    </style>

    <div ng-controller="StoreController">
        <!--<h1>Welcome {{ $shop }}</h1>-->
        <?php //echo json_encode($content); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="white-block">
                    <h3>Child Store Settings</h3>
                    <form>
                        <div class="form-group">
                            <label for="child_store_url">Store Url</label>
                            <input type="text" class="form-control" ng-model="childStore.Url" id="child_store_url" placeholder="Store Url">
                        </div>
                        <div class="form-group">
                            <label for="child_store_api_key">API Key</label>
                            <input type="text" class="form-control" ng-model="childStore.ApiKey" id="child_store_api_key" placeholder="API Key">
                        </div>
                        <div class="form-group">
                            <label for="child_store_password">Password</label>
                            <input type="text" class="form-control" ng-model="childStore.Password" id="child_store_password" placeholder="Password">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="white-block">
                    <h3>Import Products in Child Store</h3>
                    <div class="checkbox-styled">
                        <input type="checkbox" ng-model="importSettings.hidden" ng-true-value="'yes'" ng-false-value="'no'" id="hide_products" />
                        <label for="hide_products" class="noselect">Hide Products on Child Store</label>
                    </div>
                    <div class="checkbox-styled">
                        <input type="checkbox" id="overwrite_products" ng-model="importSettings.overwriteProducts" ng-true-value="'yes'" ng-false-value="'no'" />
                        <label for="overwrite_products" class="noselect">Overwrite Products on Child Store</label>
                    </div>
                    <button type="button" ng-click="importProducts()" class="btn btn-success m-t-30">Export</button>
                </div>
            </div>
        </div>
        <table class="table table-striped">
            <tr ng-repeat="product in products">
                <td>@{{ $index }}</td>
                <td>@{{ product.id }}</td>
                <td>@{{ product.handle }}</td>
                <td>@{{ product.title }}</td>
            </tr>
        </table>
    </div>
@endsection