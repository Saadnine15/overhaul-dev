@extends('layouts.main')

@section('content')

    <style>
        .white-block {
            padding: 15px 25px;
            background: #fff;
        }

        .white-block > h3 {
            text-align: center;
            margin-bottom: 30px;
            color: #0078bd;
        }
    </style>
    <div ng-controller="StoreController" data-reactroot="" class="Polaris-Page">
        <div class="Polaris-Page__Content">
            <div class="Polaris-Layout">
                {{--dashboard intro--}}
                <div class="Polaris-EmptyState">
                    <div class="Polaris-EmptyState__Section">
                        <div class="Polaris-EmptyState__DetailsContainer">
                            <h1 class="Polaris-Heading">Dashboard</h1>
                            <span class="Polaris-TextStyle--variationSubdued"> Welcome to Overhaul,
                                we make bulk product updates quick and easy.
                                Just upload your CSV, select the SKU, then identify the fields you would
                                like to update.</span>


                        </div>

                    </div>
                </div>


                {{--notification--}}
                @if(isset($firstRecord))
                    <div class="Polaris-EmptyState progressing">
                        <div class="Polaris-EmptyState__Section">
                            <div class="Polaris-EmptyState__DetailsContainer">
                                <div class="Polaris-Card">
                                    <div class="Polaris-Card__Section">
                                        <div class="Polaris-Banner" tabindex="0" role="status" aria-live="polite"
                                     aria-labelledby="Banner1Heading" aria-describedby="Banner1Content">
                                    <div class="Polaris-Banner__Ribbon"><span
                                                class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--hasBackdrop"><svg
                                                    class="Polaris-Icon__Svg" viewBox="0 0 20 20"><g
                                                        fill-rule="evenodd"><path fill="currentColor"
                                                                                  d="M2 3h11v4h6l-2 4 2 4H8v-4H3"></path><path
                                                            d="M16.105 11.447L17.381 14H9v-2h4a1 1 0 0 0 1-1V8h3.38l-1.274 2.552a.993.993 0 0 0 0 .895zM2.69 4H12v6H4.027L2.692 4zm15.43 7l1.774-3.553A1 1 0 0 0 19 6h-5V3c0-.554-.447-1-1-1H2.248L1.976.782a1 1 0 1 0-1.953.434l4 18a1.006 1.006 0 0 0 1.193.76 1 1 0 0 0 .76-1.194L4.47 12H7v3a1 1 0 0 0 1 1h11c.346 0 .67-.18.85-.476a.993.993 0 0 0 .044-.972l-1.775-3.553z"></path></g></svg></span>
                                    </div>
                                    <div>

                                        <div class="Polaris-Banner__Content" id="Banner1Content">
                                            <p>Last update was was complete
                                                on {{ Carbon\Carbon::parse($firstRecord['created_at'])->format('m/d/Y') }}
                                                . <a href="/updates">View previous updates</a></p>
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif





                {{--Progress bar--}}
                <div class="Polaris-EmptyState progressing progressBar">
                    <div class="Polaris-EmptyState__Section">
                        <div class="Polaris-EmptyState__DetailsContainer">

                            {{--<div class="Polaris-SettingAction">--}}
                            {{--<div class="Polaris-SettingAction__Setting">--}}
                            <span class="Polaris-TextStyle--variationStrong">Update in Progress</span>
                            <div class="Polaris-Stack">
                                <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                                    <div class="Polaris-AccountConnection__Content">
                                        <div class="Polaris-ProgressBar Polaris-ProgressBar--sizeMedium">
                                            <progress class="Polaris-ProgressBar__Progress" value="100"
                                                      max="100"></progress>
                                            <div class="Polaris-ProgressBar__Indicator" role="progressbar"
                                                 aria-hidden="true" style="width: 75%;"><span
                                                        class="Polaris-ProgressBar__Label">75%</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--</div>--}}

                            {{--</div>--}}

                        </div>
                    </div>
                </div>


                {{--upload your csv--}}

                <div class="Polaris-Layout__AnnotatedSection progressing">
                    <div class="Polaris-Card">
                        <div class="Polaris-Card__Section">
                            <div class="Polaris-SettingAction">
                                <div class="Polaris-SettingAction__Setting">
                                    <div class="Polaris-Stack">
                                        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                                            <div class="Polaris-AccountConnection__Content">
                                                <div>
                                                    <div class="Polaris-Button--primary oval">1</div>
                                                    <span class="card-heading">Upload your CSV</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Polaris-SettingAction__Action"><input type="file" csv-reader=""
                                                                                  save-results-callback="readCSV(csv_data)">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                {{-----------------2 select sku------------------}}
                <div class="Polaris-Layout__AnnotatedSection progressing">
                    <div class="Polaris-Card">
                        <div class="Polaris-Card__Section">
                            <div class="Polaris-SettingAction">
                                <div class="Polaris-SettingAction__Setting">
                                    <div class="Polaris-Stack">
                                        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                                            <div class="Polaris-AccountConnection__Content">
                                                <div>
                                                    <div class="Polaris-Button--primary oval">2</div>
                                                  <span class="card-heading">Select <span class="Polaris-TextStyle--variationStrong">SKU</span></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Polaris-SettingAction__Action">

                                    <div ng-if="$first" ng-repeat="headerOption in headerOptions.offered">


                                        <div class="Polaris-Select Polaris-Select--placeholder">
                                            <select class="Polaris-Select__Input" ng-disabled="!fileSelected"
                                                    aria-invalid="false"
                                                    ng-model="headerOption.mapped_to"
                                                    ng-change="updateTable(headerOption)">
                                                <option label="Select" value="__placeholder__" disabled=""
                                                        hidden="">Select Product Sku
                                                </option>
                                                <option ng-repeat="(key, value) in headerOptions.inCSV"
                                                        value="@{{ key }}">@{{ value }}
                                                </option>
                                            </select>
                                            <div class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg
                                                            class="Polaris-Icon__Svg" viewBox="0 0 20 20"><path
                                                                d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z"
                                                                fill-rule="evenodd"></path></svg></span></div>
                                            <div class="Polaris-Select__Backdrop"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-----------------3 select fields to update-----------------}}
                <div class="Polaris-Layout__AnnotatedSection progressing">
                    <div class="Polaris-Card">
                        <div class="Polaris-Card__Section">
                            <div class="Polaris-SettingAction">
                                <div class="Polaris-SettingAction__Setting">
                                    <div class="Polaris-Stack">
                                        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                                            <div class="Polaris-AccountConnection__Content">
                                                <div>
                                                    <div class="Polaris-Button--primary oval">3</div>
                                                    <span class="card-heading">
                                                    Select one or multiple fields you would like to update.<span
                                                            class="Polaris-TextStyle--variationStrong">Only selected fields
                                                            will be updated</span></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Polaris-Stack">
                                        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                                            <div class="Polaris-AccountConnection__Content">
                                                <div>
                                                    <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">

                                                        <div class="Polaris-AccountConnection__Content">
                                                            <div>
                                                                <div ng-if="!$first" ng-class="{'col-sm-4': !$first}"
                                                                     ng-repeat="headerOption in headerOptions.offered">


                                                                    <div class="Polaris-Labelled__LabelWrapper">
                                                                        <div class="Polaris-Label">
                                                                            <label id="TextField13Label"
                                                                                   for="TextField13"
                                                                                   class="Polaris-Label__Text">@{{
                                                                                headerOption.value }}</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="Polaris-Select Polaris-Select--placeholder">
                                                                        <select class="Polaris-Select__Input"
                                                                                ng-disabled="!skuSelected"
                                                                                aria-invalid="false"
                                                                                ng-model="headerOption.mapped_to"
                                                                                ng-change="updateTable(headerOption)">
                                                                            <option label="Select"
                                                                                    value="__placeholder__" disabled=""
                                                                                    hidden="">Select
                                                                            </option>
                                                                            <option ng-repeat="(key, value) in headerOptions.inCSV"
                                                                                    value="@{{ key }}">
                                                                                @{{ value }}
                                                                            </option>
                                                                        </select>
                                                                        <div class="Polaris-Select__Icon"><span
                                                                                    class="Polaris-Icon"><svg
                                                                                        class="Polaris-Icon__Svg"
                                                                                        viewBox="0 0 20 20"><path
                                                                                            d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z"
                                                                                            fill-rule="evenodd"></path></svg></span>
                                                                        </div>
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

                            </div>

                        </div>
                    </div>
                </div>


                {{-----------------4 upload section--------------------------}}
                <div class="Polaris-Layout__AnnotatedSection progressing">
                    <div class="Polaris-Card">
                        <div class="Polaris-Card__Section">
                            <div class="Polaris-SettingAction">
                                <div class="Polaris-SettingAction__Setting">
                                    <div class="Polaris-Stack">
                                        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                                            <div class="Polaris-AccountConnection__Content">
                                                <div>
                                                    Clicking the "<span class="Polaris-TextStyle--variationStrong">Update</span>"
                                                    button will overwrite the fields selected above.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Polaris-SettingAction__Action">
                                    <button disabled data-ng-click="updateProducts()" class="Polaris-Button"><span
                                                class="Polaris-Button__Content"><span>Update</span></span></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
@endsection