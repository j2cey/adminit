@extends('app', ['page_title' => "Détails Fichier Téléchargé " . $collectedreportfile->local_file_name])

@section('app_content')
    <collectedreportfile-item :collectedreportfile_prop="{{ $collectedreportfile->toJson() }}"></collectedreportfile-item>
@endsection