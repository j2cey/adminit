@extends('app', ['page_title' => "Détails Fichier " . $reportfile->name])

@section('app_content')
    <reportfile-item :reportfile_prop="{{ $reportfile->toJson() }}"></reportfile-item>
@endsection
