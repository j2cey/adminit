@extends('app', ['page_title' => "Comptes d'Accès"])

@section('app_content')
    <access-account-index :accessaccounts_prop="{{ $accessaccounts->toJson() }}"></access-account-index>
@endsection
