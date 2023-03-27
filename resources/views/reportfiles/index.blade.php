@extends('app', ['page_title' => "Fichiers du Rapport"])

@section('app_content')
    <reportfile-index :report_prop="{{ $report->toJson() }}" :reportfiles_prop="{{ $report->reportfiles->toJson() }}"></reportfile-index>
@endsection
