@extends('app', ['page_title' => "Paramètres"])

@section('app_content')
    <reportsetting-index :filemimetypes_prop="{{ $filemimetypes->toJson() }}" :reportfiletypes_prop="{{ $reportfiletypes->toJson() }}"></reportsetting-index>
@endsection
