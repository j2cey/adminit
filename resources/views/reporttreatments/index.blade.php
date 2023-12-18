@extends('app', ['page_title' => "Traitements Rapports"])

@section('app_content')
    <reporttreatment-list :reporttreatments_prop="{{ $reporttreatments->toJson() }}" :waiting_prop="{{ $waiting }}" :queued_prop="{{ $queued }}" :running_prop="{{ $running }}" :retrying_prop="{{ $retrying }}" :success_prop="{{ $success }}" :failed_prop="{{ $failed }}"></reporttreatment-list>
@endsection
