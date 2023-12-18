@extends('app', ['page_title' => "Détails Operation de Traitement"])

@section('app_content')
    <treatmentoperation-item :treatmentoperation_prop="{{ $treatmentoperation->toJson() }}"></treatmentoperation-item>
@endsection
