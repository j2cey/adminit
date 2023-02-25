@extends('layouts.core.app02')

@section('content')

    <!-- Navbar -->
    @include('layouts.admin02.nav.nav')
    <!-- /.navbar -->

    <div class="content-wrapper" style="min-height: 346px;">
        <div class="container">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h5 class="m-0 text-dark">{{ $page_title  }}</h5>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @foreach (Breadcrumbs::current() as $crumbs)
                                    @if ($crumbs->url() && !$loop->last)
                                        <li class="breadcrumb-item text-xs">
                                            <a href="{{ $crumbs->url() }}">
                                                {{ $crumbs->title() }}
                                            </a>
                                        </li>
                                    @else
                                        <li class="breadcrumb-item active text-xs">
                                            {{ $crumbs->title() }}
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- /.content -->
                @yield('app_content')

                <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    @include('layouts.admin02.controlbar')
    <!-- /.control-sidebar -->

    <!-- Admin Footer -->
    @include('layouts.admin02.footer')

@endsection
