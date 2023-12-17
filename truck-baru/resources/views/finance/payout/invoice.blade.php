@extends('layouts.master')
@section('style')
    <!-- Select 2 -->
    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
    <!-- Responsive Table css -->
    <link href="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Responsive Table js -->
    <script src="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
@endsection

@section('content')
@section('title', 'Shipments Payout UJO')
@foreach ($invoice as $item)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="panel-body">
                        <div class="clearfix">
                            <div class="float-start">
                                <h3>Satria Piranti Perkasa</h3>
                            </div>
                            <div class="float-end">
                                <h4>REQUEST PAYMENT # <br>
                                    <strong>{{ $item->noinvoice }}</strong>
                                </h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="float-start mt-3">
                                    <p>
                                        <strong>Request Date: </strong> {{ $item->tglinvoice }}<br>
                                        <strong>No UJO : </strong> {{ $item->noujo }} <br>
                                        <strong>Driver : </strong> {{ $item->getujo->getshipment->getdriver->namadriver }}
                                    </p>
                                    <address>
                                        <strong>Payment Description :</strong><br>
                                        {{ $item->keterangan }}<br>

                                    </address>
                                </div>
                                <div class="float-end mt-3">
                                    {{-- <p>
                                        <strong>Kategori : </strong> {{ $item->getrute->getkategori->namakategori }}<br>
                                        <strong>Customer : </strong> {{ $item->getcustomer->namacustomer }}<br>
                                        <strong>Project : </strong> {{ $item->getrute->getproject->namaproject }}<br>
                                        <strong>Driver: </strong> <span
                                            class="label label-pink">{{ $item->getdriver->namadriver }}</span><br>
                                        <strong>Unit : </strong> #{{ $item->getunit->kdunit }} - {{ $item->getunit->plat }} - {{ $item->getunit->merk }}
                                    </p> --}}
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-xl-6 col-6">
                                <div class="clearfix mt-4">

                                </div>
                            </div>
                            <div class="col-xl-3 col-6 offset-xl-3">
<br>
                                <h3 class="text-end">Total RP {{ number_format($item->total) }}</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="d-print-none">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light"><i
                                        class="fa fa-print"></i></a>
                                <a href="{{ route('ujo.listujo') }}"
                                    class="btn btn-primary waves-effect waves-light">Close</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endforeach
@endsection
