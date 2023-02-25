@extends('app')

@section('app_content')

    <section class="section">

        <div class="container-fluid">
            <subject-details :subject_prop="{{ $subject->toJson() }}"></subject-details>
        </div>

    </section>

@endsection
