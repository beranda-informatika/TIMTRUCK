@extends('layouts.master-without-nav')

@section('title')
    Confirm Password
@endsection

@section('css')
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ URL::asset('/buildlibs/owl.carousel/owl.carousel.min.css') }}">
@endsection

@section('body')

    <body class="auth-body-bg">
    @endsection

    @section('content')

        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">

                    <div class="col-xxl-3 col-lg-4 col-md-5">
                        <div class="auth-full-page-content p-md-5 p-4">
                            <div class="w-100">

                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5 text-center">
                                        <a href="index" class="d-block auth-logo">
                                            <img src="{{ URL::asset('/build/images/logo-sm.svg') }}" alt="" height="28">
                                            <span class="logo-txt">Satria Piranti Perkasa</span>
                                        </a>
                                    </div>
                                    <div class="my-auto">

                                        <div>
                                            <h5 class="text-primary"> Confirm Password</h5>
                                            <p class="text-muted">Re-Password with Satria Piranti Perkasa.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('password.confirm') }}">
                                                @csrf

                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        @if (Route::has('password.request'))
                                                            <a href="{{ route('password.request') }}"
                                                                class="text-muted">Forgot password?</a>
                                                        @endif
                                                    </div>
                                                    <label for="userpassword">Password</label>
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" id="userpassword" placeholder="Enter password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="text-end">
                                                    <button class="btn btn-primary w-md waves-effect waves-light"
                                                        type="submit">Confirm Password</button>
                                                </div>

                                            </form>
                                            <div class="mt-5 text-center">
                                                <p>Remember It ? <a href="{{ route('login') }}"
                                                        class="font-weight-medium text-primary"> Sign In here</a> </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 mt-md-5 text-center">
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> Satria Piranti Perkasa. Crafted with <i
                                                class="mdi mdi-heart text-danger"></i> </p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xxl-9 col-lg-8 col-md-7">
                        <div class="auth-bg pt-md-5 p-4 d-flex">
                            <div class="bg-overlay bg-primary"></div>
                            <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <!-- end bubble effect -->
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-7">
                                    <div class="p-0 p-sm-4 px-xl-0">
                                        <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div
                                                class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                                <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                    data-bs-slide-to="0" class="active" aria-current="true"
                                                    aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                    data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                    data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                            <!-- end carouselIndicators -->
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“Layanan penjualan / sewa berbagai tipe dan merk forklift dengan harga yang bersaing.”
                                                        </h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-shrink-0">
                                                                    <img src="build/images/users/avatar-1.jpg"
                                                                        class="avatar-md img-fluid rounded-circle"
                                                                        alt="...">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">JUAL / SEWA FORKLIFT
                                                                    </h5>
                                                                    <p class="mb-0 text-white-50">Department</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="carousel-item">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“Layanan penyewaan berbagai jenis kendaraan / mobil penumpang untuk dapat menunjang kebutuhan usaha Anda” 
                                                        SEWA GUDANG
Layanan penyewaan gudang yang dapat disesuaikan dengan kebutuhan bisnis Anda.
                                                        </h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-shrink-0">
                                                                    <img src="build/images/users/avatar-2.jpg"
                                                                        class="avatar-md img-fluid rounded-circle"
                                                                        alt="...">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">SEWA GUDANG
                                                                    </h5>
                                                                    <p class="mb-0 text-white-50">Department</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="carousel-item">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“Penjualan ban solid forklift berbagai merk, tipe dan ukuran beserta layanan press ke velg” 
                                                        BATERAI TRACTION
Penyediaan baterai sumber daya forklift sesuai kebutuhan tipe unit yang Anda miliki.
                                                        </h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <img src="build/images/users/avatar-3.jpg"
                                                                    class="avatar-md img-fluid rounded-circle" alt="...">
                                                                <div class="flex-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">BAN SOLID FORKLIFT</h5>
                                                                    <p class="mb-0 text-white-50">Department
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end carousel-inner -->
                                        </div>
                                        <!-- end review carousel -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>
    @endsection

    @section('script')
        <!-- owl.carousel js -->
        <script src="{{ URL::asset('/buildlibs/owl.carousel/owl.carousel.min.js') }}"></script>
        <!-- auth-2-carousel init -->
        <script src="{{ URL::asset('/buildjs/pages/auth-2-carousel.init.js') }}"></script>
    @endsection
