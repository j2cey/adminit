@extends('app', ['page_title' => "Champs du Rapport"])

@section('app_content')
    <reportattribute-index :report_prop="{{ $report->toJson() }}" :reportattributes_prop="{{ $dynamicattributes->toJson() }}"></reportattribute-index>
@endsection
