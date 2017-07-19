@extends('layouts.main')

@section('content')
    <div ng-controller="StoreController" data-reactroot="" class="Polaris-Page">
        <section class="section">
        <div class="container">
            <div class="w-row">
                <div class="w-col w-col-8"><img class="overhaul-logo" src="{{ secure_asset('assets/admin/images/overhaul-text.svg') }}">
                    <p class="get-started-text">Welcome to Overhaul, we make bulk product updates quick and easy. Just upload your CSV, select the SKU, then identify the fields you would like to update.</p>
                </div>
                <div class="w-clearfix w-col w-col-4"><img class="crane-img" src="{{ secure_asset('assets/admin/images/overhaul-icon.svg') }}"></div>
            </div>
            <section>
                <div class="step-circle">
                    <div>1</div>
                </div>
                <div class="step-header">Upload your CSV</div>
                <div class="selector-container">
                    <div class="upload-title">Upload your CSV</div>
                    <div>No file chosen</div>
                    <div><input type="file" csv-reader="" save-results-callback="readCSV(csv_data)"></div>
                </div>
                <div class="row w-row">
                    <div class="col-pad-fix-left w-col w-col-3 w-col-stack">
                        <div ng-show="fileSelected!=true"   class="opacity-overlay"></div>
                        <div class="step-circle">
                            <div>2</div>
                        </div>
                            <div class="step-header">Select SKU</div>
                            <div class="selector-container">
                                <div ng-if="$first"   ng-repeat="headerOption in headerOptions.offered">
                                    <div class="upload-title">@{{ headerOption.value }} <span class="highlight-text">(required)</span></div>
                                    <div class="w-form">
                                    <select class="select-field w-select"  aria-invalid="false" ng-model="headerOption.mapped_to" ng-change="updateTable(headerOption)" >
                                        <option label="Select" value="__placeholder__" disabled="" hidden=""></option>
                                        <option ng-repeat="(key, value) in headerOptions.inCSV" value="@{{ key }}">@{{ value }}</option>
                                    </select>
                                <div class="w-form-done">
                                    <div>Thank you! Your submission has been received!</div>
                                </div>
                                <div class="w-form-fail">
                                    <div>Oops! Something went wrong while submitting the form</div>
                                </div>
                            </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-pad-fix-right w-col w-col-9 w-col-stack">
                        <div class="step-circle">
                            <div>3</div>
                        </div>
                        <div class="step-header">Select fields you would like to update</div>
                        <div class="selector-container">
                            <div class="w-row">
                                <div ng-if="!$first"   ng-repeat="headerOption in headerOptions.offered">
                                    <div class="w-col w-col-4" >
                                        <div class="block-padding">
                                            <div class="upload-title">@{{ headerOption.value }}</div>
                                            <div class="w-form">
                                                    <select class="select-field w-select" aria-invalid="false" ng-model="headerOption.mapped_to" ng-change="updateTable(headerOption)" >
                                                        <option label="Select" value="__placeholder__" disabled="" hidden=""></option>
                                                        <option ng-repeat="(key, value) in headerOptions.inCSV" value="@{{ key }}">@{{ value }}</option>
                                                    </select>

                                                <div class="w-form-done">
                                                    <div>Thank you! Your submission has been received!</div>
                                                </div>
                                                <div class="w-form-fail">
                                                    <div>Oops! Something went wrong while submitting the form</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div ng-show="skuSelected==false" class="opacity-overlay"></div>
                    </div>
                </div>
                <div ng-show="showTable==true" class="results selector-container">
                    <div class="w-row">
                        <div class="padding-none w-col w-col-3" ng-repeat="headerOption in headerOptions.offered">
                            <div class="info-padding upload-title">@{{ headerOption.value }}</div>
                        </div>

                    </div>
                    <div class="w-row"  ng-repeat="row in table">

                        <div class="padding-none w-col w-col-3" ng-repeat="headerOption in headerOptions.offered">

                            <div class="info-container">
                                <div class="info-padding">@{{ row[headerOption.key] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </section>
    </div>



@endsection