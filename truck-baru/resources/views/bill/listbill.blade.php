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
@section('title', 'Shipment List bill')
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

<div class="row">

    <div class="col-12">



        <div class="card">

            <div class="card-body">
                <a href="{{ route('bill.index') }}" class="btn btn-primary mb-3">Back</a>
                <div class="responsive-table-plugin">
                    <div class="table-rep-plugin">
                        <div class="table-responsive" data-pattern="priority-columns"  style="overflow-x:scroll;">
                            <table id="datatable" class="table table-striped nowrap">

                                <thead>
                                    <tr>

                                        <th scope="col">No.bill</th>
                                        <th scope="col">Shipmentid</th>
                                        <th scope="col">tgl.bill</th>
                                        <th scope="col">Tgl.payment</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($bill as $key)
                                        <tr>
                                            <td scope="col">{{ $key->nobill }}</td>
                                            <td scope="col">{{ $key->shipmentid }}</td>
                                            <td scope="col">{{ $key->tglbill }}</td>
                                            <td scope="col">{{ $key->tglpayment }}</td>
                                            <td scope="col">{{ $key->f_status }}</td>
                                            <td scope="col">

                                                <a href="{{ URL::to('/bill/bill/' . $key->nobill) }}"><i
                                                        class="fa fa-print " aria-hidden="true"></i></a>
                                            </td>


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

@endsection
