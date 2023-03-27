@extends('app', ['page_title' => "Champs du Rapport"])

@section('app_content')
    <reportattribute-index :report_prop="{{ $report->toJson() }}" :reportattributes_prop="{{ $report->dynamicattributes->toJson() }}"></reportattribute-index>
@endsection
