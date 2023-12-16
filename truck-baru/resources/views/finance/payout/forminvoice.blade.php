@extends('layouts.master')
@section('css')
    <!-- Select 2 -->
    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('content')
@section('title', 'Finance')
@include('sweetalert::alert')
@foreach ($shipment as $key)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">REQUEST PAYMENT UJO</h4>
                <p class="sub-header">
                    Form UJO
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
                <form role="form" class="parsley-examples" action="{{ route('payout.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-lg-6">


                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">No. ID * (otomatis)</label>
                                <input type="text" id="shipmentid" name="shipmentid" class="form-control" value="{{ $key->shipmentid }}"
                                    readonly style="background: rgb(235, 234, 234)">
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Quotation ID</label>
                                <select class="form-select" id="orderid" name="orderid" required style="background: rgb(235, 234, 234)">
                                    <option value="{{ $key->quotationid }}">{{ $key->quotationid }}</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Customer</label>
                                <input type="text" id="kdcustomer" name="kdcustomer" class="form-control"
                                    value="{{ $key->kdcustomer }}" readonly style="background: rgb(235, 234, 234)">
                                    <div id="namacustomer">{{ $key->getcustomer->namacustomer }} </div>
                            </div>

                            <div class="mb-3">
                                <label for="example-select" class="form-label">Sales</label>
                                <input type="text" id="kdsales" name="kdsales" class="form-control" value="{{ $key->kdsales }}"
                                    readonly style="background: rgb(235, 234, 234)">
                                    <div id="namasales">{{ $key->getsales->namasales }} </div>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Project</label>
                                <input type="text" id="kdproject" name="kdproject" class="form-control" value="{{ $key->kdproject }}"
                                    readonly style="background: rgb(235, 234, 234)">
                                    <div id="namaproject">{{ $key->getproject->namaproject }} </div>
                            </div>

                        </div> <!-- end col -->

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Kategori</label>
                                <select class="form-select" id="kdkategori" name="kdkategori" readonly style="background: rgb(235, 234, 234)">
                                    <option value="">Pilih Kategori</option>
                                    <option value="{{ $key->kdkategori }}" selected>{{ $key->getkategori->namakategori }}</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Unit</label>
                                <select class="form-select" id="kdunit" name="kdunit" required readonly style="background: rgb(235, 234, 234)">
                                    <option value="{{ $key->kdunit }}">{{ $key->getunit->plat }}</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Type Truck</label>
                                <select class="form-select" id="kdunit" name="kdunit" required readonly style="background: rgb(235, 234, 234)">
                                    <option value="{{ $key->typetruckid }}">{{ $key->gettypetruck->namatypetruck }}</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Driver</label>
                                <select class="form-select" id="kddriver" name="kddriver" required readonly style="background: rgb(235, 234, 234)">
                                    <option value="{{ $key->kddriver }}">{{ $key->getdriver->namadriver }}</option>

                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="example-textarea" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="description" name="description" rows="5" required readonly style="background: rgb(235, 234, 234)">{{ $key->description }}</textarea>
                            </div>

                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered mb-0" style="text-align: left; font-size: 12px">
                                <thead>

                                    <tr class="table-danger">
                                        <td>Checked</td>
                                        <th scope="col">Rate Id</th>
                                        <th scope="col">Nama Rate</th>
                                        <th scope="col">Nominal</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Jumlah</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <form>
                                        <?php $i = 0;
                                        $total = 0;


                                        ?>

                                        @foreach ($datarate as $data)
                                            <tr>
                                                <td width="3%">
                                                    <input type="checkbox" name="checked[]" id="checked{{ $i }}"
                                                        value="{{ $data->id }}">
                                                </td>
                                                <td width="3%">
                                                    <input type="hidden" name="id[]" id="id{{ $i }}"
                                                    value="{{ $data->id }}" readonly
                                                    style="text-align: left; width: 50px; background:rgb(239, 237, 237) ">

                                                    <input type="hidden" name="rateid[]" id="rateid{{ $i }}"
                                                        value="{{ $data->rateid }}" readonly
                                                        style="text-align: left; width: 50px; background:rgb(239, 237, 237) ">
                                                    {{ $data->rateid }}
                                                    <div id="kode" style="display:none"><?php echo $i; ?></div>
                                                </td>
                                                <td width="15%">
                                                    <input type="hidden" name="namarate[]" id="namarate{{ $i }}"
                                                        value="{{ $data->getrate->namarate }}"
                                                        style="text-align: left; width: 100px; background:rgb(239, 237, 237)" require readonly>
                                                    {{ $data->getrate->namarate }}
                                                </td>

                                                <td width="10%" style="text-align: right;">
                                                    <input class="innilai" type="text" name="nominal[]" id="nominal{{ $i }}"
                                                        value="{{ $data->nominal }}" style="text-align: right; width: 100px" readonly>
                                                </td>

                                                <td width="5%" style="text-align: right;">
                                                    <input class="innilai" type="number" name="qty[]" id="qty{{ $i }}"
                                                        value="{{ $data->qty }}" style="text-align: right; width: 50px" readonly>

                                                </td>
                                                <td width="10%" style="text-align: right;">
                                                    <input class="innilai" type="text" name="jumlah[]" id="jumlah{{ $i }}"
                                                        value="{{ $data->jumlah }}" style="text-align: right; width: 100px" readonly required>

                                                </td>


                                            </tr>
                                            <?php $i++; $total=$total+$data->jumlah; ?>
                                        @endforeach
                                        <tr>
                                            <td colspan="5" style="text-align: right;">
                                                Jumlah :
                                            </td>
                                            <td style="text-align: right;">
                                                <input type="hidden" value="{{ $total }}" name="total" id="total">

                                                {{ number_format($total) }}</td>
                                        </tr>
                                        @if ($datarate->count()>0)
                                        <tr>
                                            <td colspan="10" style="text-align: right">
                                                <div class="mb-3" >
                                                    <label for="example-select" class="form-label">Rekening</label><br>
                                                     A.n: {{ $key->getdriver->namarekening }} <br>
                                                     Bank: {{ $key->getdriver->bank }} <br>
                                                     No.Rek: {{ $key->getdriver->norekening }}<br>
                                                     <small style="color: red">*mohon dicek kembali no rekening driver</small>
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light">Simpan
                                                        </button>
                                                    <a href="{{ route('shipment.detail',$key->shipmentid) }}"
                                                        class="btn btn-secondary waves-effect">Cancel</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif






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
@endforeach
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


    function total() {
        var x = {{ count($key->getdetailshipment) }};
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

            $("#jumlah" + counter).val(jumlah);
            total();
        }
    };

    $('.innilai').change(function() {
        var counter = $(this).closest('tr').find('#kode').text();
        hitung(counter);
    });




</script>


@endsection
