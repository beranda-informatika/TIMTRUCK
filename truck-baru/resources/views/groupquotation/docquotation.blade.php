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
@section('title', 'Shipments Approve')
@foreach ($groupquotation as $itemgroupquotation)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="panel-body">
                        <div class="clearfix">
                            <div class="float-start">
                                <h3>{{ $itemgroupquotation->getkategori->namakategori }} </h3>
                            </div>
                            <div class="float-end">
                                <h4>Quotation # <br>
                                    <strong>{{ $itemgroupquotation->groupquotationid }}</strong>
                                </h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <img src="{{ asset('build/images/logo.jpg') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="float-start mt-3">
                                    <p>
                                        <strong>Quotation Date: </strong> {{ date_format(date_create($itemgroupquotation->datecreated),'d/M/Y') }}<br>

                                            <strong>Category : </strong>
                                            {{ $itemgroupquotation->getkategori->namakategori }}<br>
                                            <strong>Customer : </strong> {{ $itemgroupquotation->getcustomer->namacustomer }}<br>


                                    </p>

                                    <address>
                                        <strong>Description :</strong><br>
                                        {!! $itemgroupquotation->description !!}<br>

                                    </address>


                                </div>
                                <div class="float-end mt-3">

                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table mt-2">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th scope="col">Origin</th>
                                                    <th scope="col">Destination</th>
                                                    <th scope="col">Type Truck</th>
                                                    <th scope="col">Type Route</th>
                                                    <th scope="col" style="text-align: right;">MRC</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1; @endphp
                                                @foreach ($quotation as $item)
                                                    <tr style="line-height: 10px;">
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $item->origin }}</td>
                                                        <td>{{ $item->destination }}</td>
                                                        <td>{{ $item->gettypetruck->namatypetruck }}</td>
                                                        <td>{{ $item->typeroute }}</td>
                                                        <td style="text-align: right;">{{ number_format($item->mrc) }}</td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        <hr>
                        <div class="d-print-none">
                            <div class="float-end">
                                        <a href="{{ URL::to('/groupquotation/pdfquotation/' . $itemgroupquotation->groupquotationid) }}"
                                            class="btn btn-dark" target="_blank"><i class="fa fa-file-pdf"></i>
                                            </a>

                                <a href="{{ route('groupquotation.index') }}"
                                    class="btn btn-primary waves-effect waves-light">Back</a>
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
