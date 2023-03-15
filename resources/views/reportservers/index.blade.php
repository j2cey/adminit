@extends('app', ['page_title' => "Rapport de serveurs"])

@section('app_content')
    <reportserver-index :reportservers_prop="{{ $reportservers->toJson() }}"></reportserver-index>
@endsection
