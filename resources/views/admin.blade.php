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

            <input type="file" csv-reader="" save-results-callback="readCSV(csv_data)">

            <br/>
            <div class="row" ng-repeat="headerOption in headerOptions.offered">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>@{{ headerOption.value }}</label>
                        <!--<select class="form-control">
                            <option ng-repeat="(key, option) in headerOptions.offered" value="@{{ option.key }}">@{{ option.value }}</option>
                        </select>-->
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <select class="form-control" ng-model="headerOption.mapped_to" ng-change="updateTable(headerOption)">
                            <option ng-repeat="(key, value) in headerOptions.inCSV" value="@{{ key }}">@{{ value }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <td ng-repeat="headerOption in headerOptions.offered">@{{ headerOption.value }}</td>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="row in table track by $index">
                        <td ng-repeat="headerOption in headerOptions.offered">@{{ row[headerOption.key] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection