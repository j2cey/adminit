@extends('app', ['page_title' => "Comptes d'Accès"])

@section('app_content')
    <accessaccount-index :accessaccounts_prop="{{ $accessaccounts->toJson() }}"></accessaccount-index>
@endsection
