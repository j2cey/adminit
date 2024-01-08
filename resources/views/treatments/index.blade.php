@extends('app', ['page_title' => "Traitements Rapports"])

@section('app_content')
    <treatment-index :treatments_prop="{{ $treatments->toJson() }}" :waiting_count_prop="{{ $waiting_count }}" :queued_count_prop="{{ $queued_count }}" :running_count_prop="{{ $running_count }}" :retrying_count_prop="{{ $retrying_count }}" :success_count_prop="{{ $success_count }}" :failed_count_prop="{{ $failed_count }}" ></treatment-index>
@endsection
