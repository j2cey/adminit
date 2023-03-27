@extends('app', ['page_title' => "Fichiers du Rapport"])

@section('app_content')
    <reportfile-index :report_prop="{{ $report->toJson() }}" :reportfiles_prop="{{ $reportfiles->toJson() }}"></reportfile-index>
@endsection
