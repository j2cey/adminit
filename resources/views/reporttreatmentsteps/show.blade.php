@extends('app', ['page_title' => "Détails Etape de Traitement de Rapport"])

@section('app_content')
    <reporttreatmentstep-item :reporttreatmentstep_prop="{{ $reporttreatmentstep->toJson() }}"></reporttreatmentstep-item>
@endsection
