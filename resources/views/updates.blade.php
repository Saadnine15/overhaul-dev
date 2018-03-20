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
                @foreach($records as $record)
                <dl class="Polaris-DescriptionList">
                    <dt class="Polaris-DescriptionList__Term"><a href="#">{{ Carbon\Carbon::parse($record['created_at'])->format('%B, %d %Y') }}</a></dt>
                    <dd class="Polaris-DescriptionList__Description">20 record changed</dd>

                </dl>
                @endforeach

            </div>
        </div>

    </div>
@endsection