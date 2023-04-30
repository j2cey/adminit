@extends('app', ['page_title' => "Détails Etape de Traitement de Rapport"])

@section('app_content')
<reporttreatmentstepresult-item :reporttreatmentstepresult_prop="{{ $reporttreatmentstepresult->toJson() }}"></reporttreatmentstepresult-item>
@endsection
