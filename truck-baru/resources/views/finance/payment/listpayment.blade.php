@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@section('title', 'Shipment List Payout')
<div id="myModal" class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog"
    aria-labelledby="scrollableModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollableModalTitle">Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id="formpay">
    <div class="row">

        <div class="col-12">



            <div class="card">

                <div class="card-body">

                    <a href="{{ route('payment.index') }}" class="btn btn-primary mb-3">Back</a>
                    <div class="responsive-table-plugin">
                        <div class="table-rep-plugin">
                            <div class="table-responsive" data-pattern="priority-columns" style="overflow-x:scroll;">
                                <table id="datatable" class="table table-striped nowrap">

                                    <thead>
                                        <tr>
                                            <th scope="col">No.Trans</th>
                                            <th scope="col">No.Ujo</th>
                                            <th scope="col">SO ID</th>
                                            <th scope="col">Date Payment</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">BANK</th>
                                            <th scope="col">Nama Rekening</th>
                                            <th scope="col">No Rekening</th>




                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
                                        @foreach ($payment as $key)
                                            <tr>
                                                <td scope="col">{{ $key->id }}</td>
                                                <td scope="col">{{ $key->noinvoice }}</td>
                                                <td scope="col">{{ $key->shipmentid }}</td>
                                                <td scope="col">{{ $key->datepayment }}</td>
                                                <td scope="col">{{ number_format($key->jumlah) }}</td>
                                                <td scope="col">{{ $key->bank }}</td>
                                                <td scope="col">{{ $key->namarekening }}</td>
                                                <td scope="col">{{ $key->norekening }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<!-- Required datatable js -->
<script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>

<!-- init js -->
<script src="{{ URL::asset('build/js/pages/datatable-pages.init.js') }}"></script>
<!-- Buttons examples -->
{{-- <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script> --}}
<script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
{{-- <script src="{{ URL::asset('build/libs/pdfmake/vfs_fonts.js') }}"></script> --}}
{{-- <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
</script> --}}

<!-- Datatable init js -->
<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
@endsection
