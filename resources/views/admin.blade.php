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

            <input type="file" csv-reader="" save-results-callback="readCSV(results)">

            <br/>
            <div class="row" ng-repeat="headerOption in headerOptions.offered">
                <div class="col-sm-6">
                    <div class="form-group">
                        <select class="form-control">
                            <option ng-repeat="(key, value) in headerOptions.offered" value="@{{ key }}">@{{ value }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <select class="form-control">
                            <option ng-repeat="(key, value) in headerOptions.inCSV" value="@{{ key }}">@{{ value }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection