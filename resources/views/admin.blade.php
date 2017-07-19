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
                        <div class="opacity-overlay"></div>
                        <div class="step-circle">
                            <div>2</div>
                        </div>
                            <div class="step-header">Select SKU</div>
                            <div class="selector-container">
                                <div ng-if="$first"   ng-repeat="headerOption in headerOptions.offered">
                                    <div class="upload-title">@{{ headerOption.value }} <span class="highlight-text">(required)</span></div>
                                    <div class="w-form">
                                <form id="email-form">
                                    <select class="select-field w-select"  aria-invalid="false" ng-model="headerOption.mapped_to" ng-change="updateTable(headerOption)" >
                                        <option label="Select" value="__placeholder__" disabled="" hidden=""></option>
                                        <option ng-repeat="(key, value) in headerOptions.inCSV" value="@{{ key }}">@{{ value }}</option>
                                    </select>
                                </form>
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
                                                <form  id="email-form" >
                                                    <select class="select-field w-select" aria-invalid="false" ng-model="headerOption.mapped_to" ng-change="updateTable(headerOption)" >
                                                        <option label="Select" value="__placeholder__" disabled="" hidden=""></option>
                                                        <option ng-repeat="(key, value) in headerOptions.inCSV" value="@{{ key }}">@{{ value }}</option>
                                                    </select>

                                                </form>
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
                        <div class="opacity-overlay"></div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    </div>


    <div ng-controller="StoreController" data-reactroot="" class="Polaris-Page">
        <div class="Polaris-Page__Content">
            <div class="Polaris-Layout">



                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">

                        <div class="Polaris-Layout__AnnotationContent">
                            <h2 class="Polaris-Heading sfui"><div class="oval">1</div>Upload your CSV</h2>
                            <div class="Polaris-Card">
                                <div class="Polaris-Card__Section">
                                    <div class="Polaris-SettingAction">
                                        <div class="Polaris-SettingAction__Setting">Upload your CSV<br>
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
                                    <div class="">

                                        <div ng-show="fileSelected==true" class="col-sm-3 " style="padding-left: 0px;">
                                            <h2 class="Polaris-Heading sfui"><div class="oval">2</div>Select SKU</h2>
                                                    <div class="custom-card">

                                                        <div ng-if="$first"   ng-repeat="headerOption in headerOptions.offered">





                                                            <div class="Polaris-Labelled__LabelWrapper">
                                                                <div class="Polaris-Label">
                                                                    <label id="TextField13Label" for="TextField13" class="Polaris-Label__Text">@{{ headerOption.value }}<div class="red"> (required)</div> </label>
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
                                        <div ng-show="skuSelected==true" class="col-sm-9 " style="padding-right: 0px;">
                                            <h2 class="Polaris-Heading sfui"><div class="oval">3</div>Select fields you would like to update</h2>
                                            <div class="custom-card">
                                                <div ng-if="!$first" ng-class="{'col-sm-4': !$first}"  ng-repeat="headerOption in headerOptions.offered">





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
                <div ng-show="showTable==true" class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__AnnotationContent">
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

    </div>
@endsection