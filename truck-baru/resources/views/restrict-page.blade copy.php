@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Error_404')
@endsection

@section('body')

    <body>
    @endsection

    @section('content')

        <div class="my-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <h1 class="display-1 fw-semibold">Ungranted</h1>
                            <h4 class="text-uppercase">Sorry, anda tidak berhak masuk halaman ini</h4>
                            <div class="mt-5 text-center">
                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('root') }}">Back to Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-10 col-xl-8">
                        <div>
                            <img src="build/images/error-img.png" alt="" class="img-fluid">
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end content -->

    @endsection
