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
    <div ng-controller="UpdatesController" data-reactroot="" class="Polaris-Page">
        <div class="Polaris-Page__Content">
            <div class="Polaris-Layout">
                {{--dashboard intro--}}
                <dl class="Polaris-DescriptionList"><dt class="Polaris-DescriptionList__Term">Logistics</dt>
                    <dd class="Polaris-DescriptionList__Description">The management of products or other resources as they travel between a point of origin and a destination.</dd><dt class="Polaris-DescriptionList__Term">Sole proprietorship</dt>
                    <dd class="Polaris-DescriptionList__Description">A business structure where a single individual both owns and runs the company.</dd><dt class="Polaris-DescriptionList__Term">Discount code</dt>
                </dl>

            </div>
        </div>

    </div>
@endsection