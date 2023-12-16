@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Recover_Password')
@endsection

@section('body')

    <body>
    @endsection

    @section('content')
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-xxl-3 col-lg-4 col-md-5">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5 text-center">
                                        <a href="index" class="d-block auth-logo">
                                            <img src="{{ URL::asset('/build/images/logo-sm.svg') }}" alt="" height="28">
                                            <span class="logo-txt">Satria Piranti Perkasa</span>
                                        </a>
                                    </div>
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Reset Password</h5>
                                            <p class="text-muted mt-2">Reset Password with Satria Piranti Perkasa.</p>
                                        </div>
                                        <form class="custom-form mt-4" method="POST"
                                            action="{{ route('password.update') }}">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $token }}">
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="useremail"
                                                    name="email" placeholder="Enter email"
                                                    value="{{ $email ?? old('email') }}" id="email" readonly>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
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

                                            <div class="mb-3">
                                                <label for="userpassword">Confirm Password</label>
                                                <input id="password-confirm" type="password" name="password_confirmation"
                                                    class="form-control" placeholder="Enter confirm password">
                                            </div>

                                            <div class="mb-3 mt-4">
                                                <button class="btn btn-primary w-100 waves-effect waves-light"
                                                    type="submit">Reset</button>
                                            </div>
                                        </form>

                                        <div class="mt-5 text-center">
                                            <p class="text-muted mb-0">Remember It ? <a href="{{ route('login') }}"
                                                    class="text-primary fw-semibold"> Sign In </a> </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> Satria Piranti Perkasa . Crafted with <i class="mdi mdi-heart text-danger"></i> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
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
