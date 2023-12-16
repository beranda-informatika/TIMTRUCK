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
                                        <strong>Invoice Date: </strong> {{ $item->tglinvoice }}<br>
                                        <strong>SO ID: </strong> {{ $item->shipmentid }} <br>
                                        <strong>Driver : </strong> {{ $item->getshipment->getdriver->namadriver }}
                                    </p>
                                    <address>
                                        <strong>Keterangan :</strong><br>
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
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class=" mt-2">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Akun</th>
                                                <th scope="col">Rate Id</th>
                                                <th scope="col">Nama Rate</th>
                                                <th scope="col">Nominal</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">pph (%)</th>
                                                <th scope="col">Amount PPh</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            $total = 0;
                                            $revenue = 0;
                                            $pph = 0;
                                            $pajak = 0;
                                            $ujodriver = 0;
                                            ?>
                                            @foreach ($item->getdetailinvoice as $data)
                                                <tr>
                                                    <td width="3%">{{ $i }}</td>
                                                    <td width="10%">
                                                        {{ $data->getrate->kdakun }} -
                                                        {{ $data->getrate->getakun->namaakun }}
                                                    </td>
                                                    <td width="3%">
                                                        {{ $data->rateid }}

                                                    </td>
                                                    <td width="15%">

                                                        {{ $data->getrate->namarate }}
                                                    </td>

                                                    <td width="10%" style="text-align: right;">

                                                        {{ number_format($data->nominal, 0) }}
                                                    </td>

                                                    <td width="5%" style="text-align: right;">

                                                        {{ $data->qty }}

                                                    </td>
                                                    <td width="10%" style="text-align: right;">

                                                        {{ number_format($data->jumlah, 0) }}

                                                    </td>
                                                    <td width="5%" style="text-align: right;">

                                                        {{ $data->pph }}

                                                    </td>
                                                    <td width="5%" style="text-align: right;">

                                                        {{ number_format($data->pajak, 0) }}

                                                    </td>

                                                </tr>
                                                <?php
                                                if ($data->getrate->kdakun == '1001') {
                                                    $revenue = $revenue + $data->jumlah;
                                                } elseif ($data->getrate->kdakun == '5003') {
                                                    $pajak = $pajak + $data->nominal;
                                                } elseif ($data->getrate->kdakun == '5002') {
                                                    $ujodriver = $ujodriver + $data->jumlah;
                                                }
                                                $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-6">
                                <div class="clearfix mt-4">

                                </div>
                            </div>
                            <div class="col-xl-3 col-6 offset-xl-3">
<br>
                                <h3 class="text-end">Total RP {{ number_format($ujodriver) }}</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="d-print-none">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light"><i
                                        class="fa fa-print"></i></a>
                                <a href="{{ route('shipment.detail',$item->shipmentid) }}"
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
