@extends('layouts.master')
@section('css')
    <script src="{{ asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('build/js/accounting.js') }}"></script>


@endsection
@section('title', 'Quotation')
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
                    <h4 class="card-title">Shipping Quotation</h4>
                </div>
                <div class="card-body p-4">

                    <form role="form" class="parsley-examples" action="{{ route('quotation.update',$quotation->id) }}" method="POST">
                        @method('PUT')
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

                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Origin</label>
                                        <input class="form-control" type="text" name="origin" id="origin"
                                            placeholder="Origin" required style="text-transform:uppercase" value="{{ $quotation->origin }}">

                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Destination</label>
                                        <input class="form-control" type="text" name="destination" id="destination"
                                            placeholder="Destination" required style="text-transform:uppercase" value="{{ $quotation->destination }}">

                                    </div>


                                    <div class="mb-3">

                                        <label for="inputEmail3" class="col-4 col-form-label">Type Truck<span
                                                class="text-danger">*</span></label>

                                        <select name="typetruckid" id="typetruckid" required class="form-control">
                                        <option value="{{ $quotation->typetruckid }}" selected>{{ $quotation->gettypetruck->namatypetruck }}</option>
                                    </select>


                                    </div>

                                    <div class="mb-3">
                                        <label for="example-date-input" class="form-label">Type Route </label>
                                        <select class="form-select" id="typeroute" name="typeroute" required>
                                            <option value="$quotation->typeroute" selected>{{ $quotation->typeroute }}</option>
                                            <option value="">--select--</option>
                                            <option value="trip" @if($quotation->typeroute=="trip") selected @endif>trip</option>
                                            <option value="load" @if($quotation->typeroute=="load") selected @endif>load</option>
                                        </select>

                                    </div>
                                    <div class="mb-3" id="panelminqty">
                                        <label for="example-text-input" class="form-label">Minimum Qty (Kg)</label>
                                        <input class="form-control" type="text" name="minqty" id="minqty"
                                            placeholder="Min QTY" style="text-align: right" value="{{ $quotation->minqty }}">
                                        <input class="form-control" type="text" name="vminqty" id="vminqty"
                                            placeholder="Min QTY" style="text-align: right; background:greenyellow" value="{{ $quotation->minqty }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">MRC</label>
                                        <input class="form-control" type="text" name="mrc" id="mrc"
                                            placeholder="MRC" style="text-align: right" value="{{ $quotation->mrc }}">
                                        <input class="form-control" type="text" name="vmrc" id="vmrc"
                                            placeholder="MRC" style="text-align: right; background:greenyellow" value="{{ $quotation->mrc }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                        <a href="{{ route('groupquotation.tabelrute',Session::get('groupquotationid') ) }}"
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
           $("#panelminqty").hide();
           var typeroute = $("#typeroute").val();
            if (typeroute == "trip") {
                $("#panelminqty").hide();
            } else {
                $("#panelminqty").show();
            }
        });
        $("#typeroute").change(function() {
            var typeroute = $("#typeroute").val();
            if (typeroute == "trip") {
                $("#panelminqty").hide();
            } else {
                $("#panelminqty").show();
            }
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
            var minqty= $("#minqty").val();
            var total = accounting.formatMoney(mrc, "Rp. ", 0, ".", ",");
            $("#vmrc").val(total);
            $("#vminqty").val(accounting.formatMoney(minqty,"", 0, ".", ","));
        }

        $("#mrc").change(function() {
            tampilnominal();
        });
        $("#minqty").change(function() {
            tampilnominal();
        });
        $("#typetruckid").select2({
            placeholder: 'Pilih Unit',
            ajax: {
                url: "{{ route('typetruck.gettypetruck') }}",
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

    </script>


@endsection
