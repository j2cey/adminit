@extends('app', ['page_title' => "Report Details"])

@section('app_content')
    <reports-details :report_prop="{{ $report->toJson() }}"></reports-details>
@endsection
