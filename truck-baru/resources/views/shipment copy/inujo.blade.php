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
                    <h4 class="card-title">Shipping Input UJO</h4>
                </div>
                <div class="card-body p-4">

                    <form role="form" class="parsley-examples" action="{{ route('shipment.storeujo') }}" method="POST">
                        @csrf
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
                                        <label for="example-select" class="form-label">Kategori</label>
                                        <input class="form-control" type="text" name="kdkategori" id="kdkategori"
                                            placeholder="kdkategori" required style="text-transform:uppercase" value="{{ $shipment->getkategori->namakategori }}" readonly>

                                    </div>
                                    <div class="mb-1">
                                        <label for="example-text-input" class="form-label">Origin</label>
                                        <input class="form-control" type="text" name="origin" id="origin"
                                            placeholder="Origin" required style="text-transform:uppercase" value="{{ $shipment->origin }}" readonly>

                                    </div>
                                    <div class="mb-1">
                                        <label for="example-text-input" class="form-label">Destination</label>
                                        <input class="form-control" type="text" name="destination" id="destination"
                                            placeholder="Destination" required style="text-transform:uppercase" value="{{ $shipment->destination }}" readonly>

                                    </div>
                                    <div class="mb-1">
                                        <label for="example-text-input" class="col-4">MRC :</label>
                                        {{ number_format($shipment->mrc) }}
                                      </div>
                                      <div class="mb-1">
                                        <label for="example-text-input" class="col-4">UJO :</label>
                                        {{ number_format($shipment->ujo) }}
                                      </div>
                                    <div class="mb-1">
                                        <label for="example-text-input" class="col-4">Description</label>
                                        <textarea class="form-control" type="text" name="description" id="description" placeholder="Description" required
                                            style="text-transform:uppercase" >{{ $shipment->description }}</textarea>

                                    </div>
                                    <div class="mb-1">

                                        <label for="inputEmail3" class="col-4">Customer<span
                                                class="text-danger">*</span></label>
                                                {{ $shipment->getcustomer->namacustomer }}

                                    </div>
                                    <div class="mb-1">
                                        <label for="inputEmail3" class="col-4">Sales<span
                                                class="text-danger">*</span></label>
                                                {{ $shipment->getsales->namasales }}


                                    </div>
                                    <div class="mb-3">

                                    @include('shipment.rateujo')
                                    </div>
                                    <div class="mb-1">
                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                        <a href="{{ route('shipment.index') }}"
                                            class="btn btn-secondary waves-effect">Cancel</a>

                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="example-date-input" class="form-label">Route References </label>
                                        <button type="button" id="refresh"
                                            class="btn btn-sm btn-primary">Open</button>
                                        <div id="tabelrute"></div>
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
           tampilnominal();
        });
        $(document).on('submit', '#formincustomer', function() {
            if (confirm("Save Customer?")) {
                $.ajax({
                    url: "{{ route('quotation.customerstore') }}",
                    type: "post",
                    data: $(this)
                        .serialize(), //mengirim data secara serialize -- seluruh data input dikirim untuk diproses
                    dataType: 'json', //respon yang diminta dalam format JSON
                    success: function(response) {
                        if (response.status == 1) // return trmahasiswa dari hasil proses
                        {
                            alert('Data berhasil disimpan');
                            $('#myModal').modal('hide');
                        } else {
                            alert('Data gagal disimpan');
                            $('#myModal').modal('hide');

                        }
                    }
                });
            };
            return false;
        });
        $(document).on('submit', '#forminsales', function() {
            if (confirm("Save Sales?")) {
                $.ajax({
                    url: "{{ route('quotation.salesstore') }}",
                    type: "post",
                    data: $(this)
                        .serialize(), //mengirim data secara serialize -- seluruh data input dikirim untuk diproses
                    dataType: 'json', //respon yang diminta dalam format JSON
                    success: function(response) {
                        if (response.status == 1) // return trmahasiswa dari hasil proses
                        {
                            alert('Data berhasil disimpan');
                            $('#myModal').modal('hide');
                        } else {
                            alert('Data gagal disimpan');
                            $('#myModal').modal('hide');

                        }
                    }
                });
            };
            return false;
        });
        $('.btn-action').click(function() {
            var url = $(this).data("url");
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                success: function(res) {

                    // get the ajax response data
                    var data = res;

                    // update modal content here
                    // you may want to format data or
                    // update other modal elements here too
                    $('.modal-body').html(data);

                    // show modal
                    $('#myModal').modal('show');

                },
                error: function(request, status, error) {
                    console.log("ajax call went wrong:" + request.responseText);
                }
            });
        });

        $("#refresh").on("click", function() {
            var origin = $("#origin").val();
            var destination = $("#destination").val();
            $.ajax({
                url: "{{ route('quotation.tabelrute') }}",
                type: "GET",
                dataType: 'html',
                data: {
                    origin: origin,
                    destination: destination
                },
                success: function(data) {
                    $("#tabelrute").html(data);
                }
            });
        });
        $('#mrc').keypress(function(e) {
            var regex = new RegExp("^[0-9_]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        function tampilnominal() {
            var mrc = $("#mrc").val();
            var total = accounting.formatMoney(mrc, "Rp. ", 0, ".", ",");
            $("#vmrc").val(total);
        }

        $("#mrc").change(function() {
            tampilnominal();
        });
        $("#kdsales").select2({
            placeholder: 'choice Sales',
            ajax: {
                url: "{{ route('sales.getsales') }}",
                type: "GET",
                dataType: 'JSON',
                delay: 250,
                data: function(params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term,
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#kdcustomer").select2({
            placeholder: 'choice Customer',
            ajax: {
                url: "{{ route('customer.getcustomer') }}",
                type: "GET",
                dataType: 'JSON',
                delay: 250,
                data: function(params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term,
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#routeid").select2({
            placeholder: 'Pilih Rute',
            ajax: {
                url: "{{ route('shipment.getrute') }}",
                type: "GET",
                dataType: 'JSON',
                delay: 250,
                data: function(params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term,
                        kdproject: $("#kdproject").val(),
                        kdkategori: $("#kdkategori").val(),
                    };
                },
                processResults: function(response) {

                    return {
                        results: response
                    };

                },

                cache: true
            }
        });
    </script>


@endsection
