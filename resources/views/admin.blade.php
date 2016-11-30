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
        <div class="white-block">
            <div class="row" ng-repeat="headerOption in headerOptions.offered">
                <div class="col-sm-6">
                    <div class="form-group">
                        <select class="form-control" ng-repeat="(key, value) in headerOptions.offered">
                            <option value="@{{ key }}">@{{ value }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <select class="form-control" ng-repeat="(key, value) in headerOptions.inCSV">
                            <option value="@{{ key }}">@{{ value }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection