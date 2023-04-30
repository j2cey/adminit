@extends('app', ['page_title' => "Traitements Rapports"])

@section('app_content')
    <reporttreatmentresult-list :reporttreatmentresults_prop="{{ $reporttreatmentresults->toJson() }}"></reporttreatmentresult-list>
@endsection
