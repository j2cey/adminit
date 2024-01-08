@extends('app', ['page_title' => "Treatment Details"])

@section('app_content')
    <treatment-details :treatment_prop="{{ $treatment->toJson() }}" :subtreatments_prop="{{ $subtreatments->toJson() }}"></treatment-details>
@endsection
