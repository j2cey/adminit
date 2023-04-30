@extends('app', ['page_title' => "Détails Traitement de Rapport"])

@section('app_content')
    <reporttreatmentresult-item :reporttreatmentresult_prop="{{ $reporttreatmentresult->toJson() }}"></reporttreatmentresult-item>
@endsection
