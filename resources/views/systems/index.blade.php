@extends('app', ['page_title' => "System"])

@section('app_content')
    <systems-index :statuses_prop="{{ $statuses->toJson() }}" :settings_grouped_prop="{{ json_encode($settings_grouped) }}" :settings_prop="{{ $settings->toJson() }}" :roles_prop="{{ $roles->toJson() }}" :users_prop="{{ $users->toJson() }}"></systems-index>
@endsection
