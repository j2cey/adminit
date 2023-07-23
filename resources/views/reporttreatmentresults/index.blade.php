@extends('app', ['page_title' => "Traitements Rapports"])

@section('app_content')
    <reporttreatmentresult-list :reporttreatmentresults_prop="{{ $reporttreatmentresults->toJson() }}" :waiting_prop="{{ $waiting }}" :queued_prop="{{ $queued }}" :running_prop="{{ $running }}" :retrying_prop="{{ $retrying }}" :success_prop="{{ $success }}" :failed_prop="{{ $failed }}"></reporttreatmentresult-list>
@endsection
