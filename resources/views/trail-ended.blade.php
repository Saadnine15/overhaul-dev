@extends('layouts.main')

@section('content')
    <div ng-controller="TrailExpiredController">
        <h3>Your trial version has been expired.</h3>
        <a href="{{ secure_url('/charge_store') }}" class="btn btn-success">Get a Paid Version</a>

    </div>
@endsection