@extends('app')

@section('app_content')

    <section class="section">

        <div class="container">
            <subject-create :subject_prop="{{ $subject->toJson() }}"></subject-create>
        </div>

    </section>

@endsection
