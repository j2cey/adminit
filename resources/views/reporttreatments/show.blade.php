@extends('app', ['page_title' => "Détails Traitement de Rapport"])

@section('app_content')
    <reporttreatment-item :reporttreatment_prop="{{ $reporttreatment->toJson() }}"></reporttreatment-item>
@endsection
