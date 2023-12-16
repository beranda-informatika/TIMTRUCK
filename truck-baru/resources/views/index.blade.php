@extends('layouts.master')

@section('title')
    @lang('translation.Dashboard')
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/jquery-vectormap/jquery-vectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/glightbox/css/glightbox.min.css') }}">
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
@endsection


@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Extended
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent



    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Quotation</h4>
                    <div class="flex-shrink-0">
                        <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#transactions-all-tab" role="tab">
                                    All
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#transactions-buy-tab" role="tab">
                                    new
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#transactions-sell-tab" role="tab">
                                    quotation
                                </a>
                            </li>
                        </ul>
                        <!-- end nav tabs -->
                    </div>
                </div><!-- end card header -->

                <div class="card-body px-0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="transactions-all-tab" role="tabpanel">
                            <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                <table class="table align-middle table-nowrap table-borderless">
                                    <tbody>

                                        @foreach ($quotationso as $quotation)
                                        <tr>
                                            <td style="width: 50px;">
                                                <div class="font-size-22 text-success">
                                                    <i class="bx bx-down-arrow-circle d-block"></i>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                    <h5 class="font-size-14 mb-1">{{ $quotation->getcustomer->namacustomer }}</h5>
                                                    <p class="text-muted mb-0 font-size-12">{{ $quotation->tglrequest }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="text-end">
                                                    <h5 class="font-size-14 mb-0">{{ $quotation->origin }}</h5>
                                                    <p class="text-muted mb-0 font-size-12">Origin</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="text-end">
                                                    <h5 class="font-size-14 text-muted mb-0">{{ $quotation->destination }}</h5>
                                                    <p class="text-muted mb-0 font-size-12">Destination</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end tab pane -->
                        <div class="tab-pane" id="transactions-buy-tab" role="tabpanel">
                            <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">

                            </div>
                        </div>

                    </div>
                    <!-- end tab content -->
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Open Shipments</a>
                            <!-- item-->

                        </div>
                    </div>

                    <h4 class="card-title mb-0 flex-grow-1">Lates Shipment</h4>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Shipment ID</th>
                                    <th>Rute</th>
                                    <th>Start Point</th>
                                    <th>Customer</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shipments as $key)
                                    <tr>
                                        <td></td>
                                        <td>{{ $key->shipmentid }}</td>
                                        <td>{{ $key->origin }} - {{ $key->destination }}</td>
                                        <td>{{ $key->tglorder }}</td>
                                        <td>{{ $key->getcustomer->namacustomer }}</td>
                                        <td>
                                            @include('statusshipment.statusshipment')
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div><!-- end col -->

    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/jquery-vectormap/jquery-vectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/lightbox.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

@endsection
