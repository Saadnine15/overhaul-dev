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
                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Card">
                        <div class="Polaris-Card__Section">
                            <dl class="Polaris-DescriptionList">
                                @foreach($records as $record)
                                    <dt class="Polaris-DescriptionList__Term"><a href="#">{{ Carbon\Carbon::parse($record['created_at'])->format('F, jS Y') }}</a></dt>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>




            </div>
        </div>

    </div>
@endsection