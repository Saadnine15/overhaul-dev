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
    <div ng-controller="StoreController" data-reactroot="" class="Polaris-Page">
        <div class="Polaris-Page__Content">
            <div class="Polaris-Layout">

                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__Annotation">
                          <div class="col-sm-8">
                              <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeExtraLarge">OVERHAUL</h1>
                              <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"> Welcome to Overhaul, we make bulk product updates quick and easy.
                                  Just upload your CSV, select the SKU, then identify the fields you would
                                  like to update.</p>


                          </div>

                            <div class="col-sm-3">
                                <img src="{{ secure_asset('assets/admin/overhaulImg.PNG') }}">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">

                        <div class="Polaris-Layout__AnnotationContent">
                            <h2 class="Polaris-Heading">1) Upload your CSV</h2>
                            <div class="Polaris-Card">
                                <div class="Polaris-Card__Section">
                                    <div class="Polaris-SettingAction">
                                        <div class="Polaris-SettingAction__Setting">Upload your CSV</div>
                                        <div class="Polaris-SettingAction__Action">
                                            <input type="file" csv-reader="" save-results-callback="readCSV(csv_data)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__AnnotationContent">
                                <div role="group" class="">
                                    <div class="Polaris-FormLayout__Items">
                                        <div class="row">
                                            <div class="col-sm-3 ">
                                                <div class="custom-card">

                                                    <div ng-if="$first"   ng-repeat="headerOption in headerOptions.offered">


                                                        <h2 class="Polaris-Heading">1) Upload your CSV</h2>


                                                        <div class="Polaris-Labelled__LabelWrapper">
                                                            <div class="Polaris-Label">
                                                                <label id="TextField13Label" for="TextField13" class="Polaris-Label__Text">@{{ headerOption.value }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="Polaris-Select Polaris-Select--placeholder">
                                                            <select class="Polaris-Select__Input" aria-invalid="false" ng-model="headerOption.mapped_to" ng-change="updateTable(headerOption)" >
                                                                <option label="Select" value="__placeholder__" disabled="" hidden=""></option>
                                                                <option ng-repeat="(key, value) in headerOptions.inCSV" value="@{{ key }}">@{{ value }}</option>
                                                            </select>
                                                            <div class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20"><path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path></svg></span></div>
                                                            <div class="Polaris-Select__Backdrop"></div>
                                                        </div>

                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-sm-9 ">
                                                <div class="custom-card">
                                                    <div ng-if="!$first" ng-class="{'col-sm-4': !$first}"  ng-repeat="headerOption in headerOptions.offered">


                                                        <h2 class="Polaris-Heading">1) Upload your CSV</h2>


                                                        <div class="Polaris-Labelled__LabelWrapper">
                                                            <div class="Polaris-Label">
                                                                <label id="TextField13Label" for="TextField13" class="Polaris-Label__Text">@{{ headerOption.value }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="Polaris-Select Polaris-Select--placeholder">
                                                            <select class="Polaris-Select__Input" aria-invalid="false" ng-model="headerOption.mapped_to" ng-change="updateTable(headerOption)" >
                                                                <option label="Select" value="__placeholder__" disabled="" hidden=""></option>
                                                                <option ng-repeat="(key, value) in headerOptions.inCSV" value="@{{ key }}">@{{ value }}</option>
                                                            </select>
                                                            <div class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20"><path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path></svg></span></div>
                                                            <div class="Polaris-Select__Backdrop"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">
                      <div class="white-block">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <td class="col-sm-3" ng-repeat="headerOption in headerOptions.offered">@{{ headerOption.value }}</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="row in table">
                                    <td  ng-repeat="headerOption in headerOptions.offered">@{{ row[headerOption.key] }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection