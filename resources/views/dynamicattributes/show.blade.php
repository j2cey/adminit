@extends('app', ['page_title' => "Détails Champs de Rapport"])

@section('app_content')
<dynamicattribute-item :model_prop="{{ $model->toJson() }}" :dynamicattribute_prop="{{ $dynamicattribute->toJson() }}"></dynamicattribute-item>
@endsection
