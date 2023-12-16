@extends('layouts.master')
@section('css')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('content')
@section('title', 'rute')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Route</h4>
                <p class="sub-header">
                    Form Input Master UJO / Tarif
                </p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Ada kesalahan input data! <br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form role="form" class="parsley-examples" action="{{ route('rute.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">


                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Route ID</label>
                                <input type="text" id="routeid" name="routeid" class="form-control"
                                    value="{{ old('routeid') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Route</label>
                                <input type="text" id="route" name="route" class="form-control"
                                    value="{{ old('route') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Kategori</label>
                                <select class="form-select" id="kdkategori" name="kdkategori" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->kdkategori }}">{{ $item->namakategori }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Project</label>
                                <select class="form-select" id="kdproject" name="kdproject" required>

                                </select>
                            </div>







                        </div> <!-- end col -->

                        <div class="col-lg-6">


                            <div class="mb-3">
                                <label for="example-select" class="form-label">Type Truck</label>
                                <select class="form-select" id="typetruckid" name="typetruckid" required>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-textarea" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="5" required>{{ old('keterangan') }}</textarea>
                            </div>

                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered mb-0" style="text-align: left; font-size: 12px">
                                <thead>

                                    <tr class="table-danger">
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
                                    <form>
                                        <?php $i = 0;
                                        $total = 0; ?>
                                        @foreach ($rate as $data)
                                            <tr>
                                                <td width="3%">
                                                    <input type="hidden" name="rateid[]" id="rateid{{ $i }}"
                                                        value="{{ $data->rateid }}" readonly
                                                        style="text-align: left; width: 50px; background:rgb(239, 237, 237) ">
                                                    {{ $data->rateid }}
                                                    <div id="kode" style="display:none"><?php echo $i; ?></div>
                                                </td>
                                                <td width="15%">
                                                    <input type="hidden" name="namarate[]"
                                                        id="namarate{{ $i }}" value="{{ $data->namarate }}"
                                                        style="text-align: left; width: 100px; background:rgb(239, 237, 237)"
                                                        require readonly>
                                                    {{ $data->namarate }}
                                                </td>

                                                <td width="10%" style="text-align: right;">
                                                    <input class="innilai" type="text" name="nominal[]"
                                                        id="nominal{{ $i }}" value=""
                                                        style="text-align: right; width: 100px">
                                                </td>

                                                <td width="5%" style="text-align: right;">
                                                    <input class="innilai" type="number" name="qty[]"
                                                        id="qty{{ $i }}" value="1"
                                                        style="text-align: right; width: 50px">

                                                </td>
                                                <td width="10%" style="text-align: right;">
                                                    <input class="innilai" type="text" name="jumlah[]"
                                                        id="jumlah{{ $i }}" value=""
                                                        style="text-align: right; width: 100px" readonly required>

                                                </td>
                                                <td width="5%" style="text-align: right;">
                                                    <input class="inpph" type="text" name="pph[]"
                                                        id="pph{{ $i }}" value="{{ $data->persenpajak }}"
                                                        max="100" style="text-align: right; width: 50px">

                                                </td>
                                                <td width="5%" style="text-align: right;">
                                                    <input type="text" name="pajak[]"
                                                        id="pajak{{ $i }}" value="0"
                                                        style="text-align: right; width: 60px" readonly>

                                                </td>

                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach





                                        <tr>
                                            <td colspan="10" style="text-align: right">
                                                <div class="mb-3">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light">Input
                                                        Rate</button>
                                                    <a href="{{ route('rute.index') }}"
                                                        class="btn btn-secondary waves-effect">Cancel</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </form>
                <!-- end row-->

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $("#typetruckid").select2({
        placeholder: 'Pilih Type Truck',
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
    $("#kdproject").select2({
        placeholder: 'Pilih Project',
        ajax: {
            url: "{{ route('project.getproject') }}",
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


    function total() {
        var x = {{ count($rate) }};
        var total = 0;
        for (i = 0; i < x; i++) {
            var jumlah = parseInt($("#jumlah" + i).val());
            total = total + jumlah;
        }

    }

    function hitung(counter) {

        var qty = $("#qty" + counter).val();
        if (parseInt(qty) < 0) {
            alert("Qty Datang Tidak Boleh 0 minimal 1");
            $("#qty" + counter).val("1");
        } else {
            var harga = $("#nominal" + counter).val();
            var qty = $("#qty" + counter).val();
            var jumlah = parseInt(harga) * parseInt(qty);
            var pph= $("#pph" + counter).val();
            var pajak = (jumlah * pph) / 100;

            $("#jumlah" + counter).val(jumlah);
            $("#pajak" + counter).val(pajak);
            total();
        }
    };

    $('.innilai').change(function() {
        var counter = $(this).closest('tr').find('#kode').text();
        hitung(counter);
    });



</script>


@endsection
@section('js')
<script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>

@endsection
