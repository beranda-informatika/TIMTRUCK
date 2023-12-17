@extends('layouts.master')
@section('css')
    <script src="{{ asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('build/js/accounting.js') }}"></script>


@endsection
@section('title', 'order')
@section('content')


    <div id="myModal" class="modal bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="col-12">
        <div class="row">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">Shipping Input Pickup</h4>
                </div>
                <div class="card-body p-4">

                    <form role="form" class="parsley-examples" action="{{ route('shipment.storepickup') }}" method="POST">
                        @csrf
                        <input type="hidden" name="trshipment" id="trshipment" value="revenue">
                        <div class="row">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> Ada kesalahan data, silahkan dicek kembali<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @csrf

                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-1">
                                        <label for="example-text-input" class="form-label">Shipment ID</label>
                                        <input class="form-control" type="text" name="shipmentid" id="shipmentid"
                                            placeholder="shipmentid" required style="text-transform:uppercase" value="{{ $shipment->shipmentid }}" readonly>
                                    </div>
                                    <div class="mb-1">
                                        <label for="example-select" class="form-label">Nominal Pickup</label>
                                        <input class="form-control" type="text" name="nominal" id="nominal"
                                            placeholder="unit mrc" required style="text-transform:uppercase" value="{{ $shipment->ratepickup }}" readonly>

                                    </div>
                                    <div class="mb-1">
                                        <label for="example-text-input" class="form-label">point</label>
                                        <input class="form-control" type="number" name="qty" id="qty"
                                            placeholder="" required >

                                    </div>
                                    <div class="mb-1">
                                        <label for="example-text-input" class="form-label">Total</label>
                                        <input class="form-control" type="text" name="total" id="total"
                                            placeholder="" required  readonly>

                                    </div>



                                    <div class="mb-1">
                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                        <a href="{{ route('shipment.index') }}"
                                            class="btn btn-secondary waves-effect">Cancel</a>

                                    </div>

                                </div>
                            </div>


                        </div>
                    </form>
                </div>

            </div>
        </div> <!-- end col -->

    </div>

    <script>

        $(document).ready(function() {
            $('#qty').on('input', function() {
                var qty = $(this).val();
                var nominal = $('#nominal').val();
                var total = qty * nominal;
                $('#total').val(total);
            });
        });
    </script>


@endsection
