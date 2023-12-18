@extends('layouts.master')
@section('css')
    <!-- Select 2 -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('/build/js/accounting.js') }}"></script>
@endsection
@section('content')
@section('title', 'Finance')
@include('sweetalert::alert')
@foreach ($ujo as $key)
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
                            <strong>Whoops!</strong> There were some problems with your input. <br><br>
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
                                    <label for="simpleinput" class="form-label">No. UJO</label>
                                    <input type="text" id="noujo" name="noujo" class="form-control"
                                        value="{{ $key->noujo }}" readonly style="background: rgb(235, 234, 234)">
                                </div>
                                <div class="mb-3">
                                    <label for="example-select" class="form-label">NO SO </label>
                                    <select class="form-select" id="orderid" name="orderid" required
                                        style="background: rgb(235, 234, 234)">
                                        <option value="{{ $key->getshipment->shipmentid }}">
                                            {{ $key->getshipment->shipmentid }}</option>

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="example-select" class="form-label">Customer</label>
                                    <input type="text" id="kdcustomer" name="kdcustomer" class="form-control"
                                        value="{{ $key->getshipment->kdcustomer }}" readonly
                                        style="background: rgb(235, 234, 234)">
                                    <div id="namacustomer">{{ $key->getshipment->getcustomer->namacustomer }} </div>
                                </div>

                                <div class="mb-3">
                                    <label for="example-select" class="form-label">Sales</label>
                                    <input type="text" id="kdsales" name="kdsales" class="form-control"
                                        value="{{ $key->getshipment->kdsales }}" readonly
                                        style="background: rgb(235, 234, 234)">
                                    <div id="namasales">{{ $key->getshipment->getsales->namasales }} </div>
                                </div>
                                <div class="mb-3">
                                    <label for="example-select" class="form-label">Project</label>
                                    <input type="text" id="kdproject" name="kdproject" class="form-control"
                                        value="{{ $key->getshipment->kdproject }}" readonly
                                        style="background: rgb(235, 234, 234)">
                                    <div id="namaproject">{{ $key->getshipment->getproject->namaproject }} </div>
                                </div>

                            </div> <!-- end col -->

                            <div class="col-lg-6">


                            </div> <!-- end col -->
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <table class="table table-bordered mb-0" style="text-align: left; font-size: 12px">
                                    <thead>

                                        <tr class="table-danger">
                                            <th scope="col">Rate Id</th>
                                            <th scope="col">Name Rate</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form>
                                            <?php $i = 0;


                                            ?>

                                            @foreach ($detailujo as $data)
                                                <tr>

                                                    <td width="3%">
                                                        <input type="hidden" name="id[]" id="id{{ $i }}"
                                                            value="{{ $data->id }}" readonly
                                                            style="text-align: left; width: 50px; background:rgb(239, 237, 237) ">

                                                        <input type="hidden" name="rateid[]"
                                                            id="rateid{{ $i }}" value="{{ $data->rateid }}"
                                                            readonly
                                                            style="text-align: left; width: 50px; background:rgb(239, 237, 237) ">
                                                        {{ $data->rateid }}
                                                        <div id="kode" style="display:none"><?php echo $i; ?>
                                                        </div>
                                                    </td>
                                                    <td width="15%">
                                                        <input type="hidden" name="namarate[]"
                                                            id="namarate{{ $i }}"
                                                            value="{{ $data->getrate->namarate }}"
                                                            style="text-align: left; width: 100px; background:rgb(239, 237, 237)"
                                                            require readonly>
                                                        {{ $data->getrate->namarate }}
                                                    </td>
                                                    <td width="15%">
                                                        <input type="hidden" name="descript[]"
                                                            id="descript{{ $i }}"
                                                            value="{{ $data->getrate->descript }}"
                                                            style="text-align: left; width: 100px; background:rgb(239, 237, 237)"
                                                            require readonly>
                                                        {{ $data->getrate->descript }}
                                                    </td>
                                                    <td width="10%" style="text-align: right;">
                                                        <input class="innilai" type="text" name="nominal[]"
                                                            id="nominal{{ $i }}"
                                                            value="{{ $data->nominal }}"
                                                            style="text-align: right; width: 100px" readonly>
                                                    </td>

                                                </tr>
                                                <?php $i++;
                                               ?>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" style="text-align: right;">
                                                    Total :
                                                </td>
                                                <td style="text-align: right;">
                                                    <input type="hidden" value="{{ $key->nominalujo }}"
                                                        name="nominalujo" id="nominalujo">

                                                    {{ number_format($key->nominalujo) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">
                                                    Paid off :
                                                </td>
                                                <td style="text-align: right;">
                                                    <input type="hidden" value="{{ $key->terbayar }}"
                                                        name="terbayar" id="terbayar">

                                                    {{ number_format($key->terbayar) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">
                                                    Remaining Payment :
                                                </td>
                                                <td style="text-align: right;">
                                                    <input type="hidden"
                                                        value="{{ $key->nominalujo - $key->terbayar }}"
                                                        name="remainingpayment" id="remainingpayment">

                                                    {{ number_format($key->nominalujo - $key->terbayar) }}
                                                </td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">
                                                    Request Payment :
                                                </td>
                                                <td style="text-align: right;">
                                                    <input type="text" value="" name="bayar"
                                                        id="bayar" style="text-align: right">
                                                        <input type="text" value="" name="vbayar"
                                                        id="vbayar" style="text-align: right; background:cyan" readonly>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: left;">
                                                    Payment Description :
                                                </td>
                                                <td colspan="2"style="text-align: right;">
                                                    <input type="text" value="" name="description"
                                                        id="description" size=50>


                                                </td>
                                            </tr>
                                            @if ($detailujo->count() > 0)
                                                <tr>
                                                    <td colspan="10" style="text-align: right">
                                                        <div class="mb-3">
                                                            <label for="example-select"
                                                                class="form-label">Rekening</label><br>
                                                            A.n: {{ $key->getshipment->getdriver->namarekening }} <br>
                                                            Bank: {{ $key->getshipment->getdriver->bank }} <br>
                                                            No.Rek: {{ $key->getshipment->getdriver->norekening }}<br>
                                                            <small style="color: red">*mohon dicek kembali no rekening
                                                                driver</small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <button type="submit"
                                                                class="btn btn-primary waves-effect waves-light">Submit
                                                            </button>
                                                            <a href="{{ route('ujo.listujo', $key->noujo) }}"
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
        var x = {{ count($detailujo) }};
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

    $('#bayar').keyup(function() {
        var bayar = parseInt($('#bayar').val());
        var remainingpayment = parseInt($('#remainingpayment').val());
        var nominalujo = parseInt($('#nominalujo').val());
        var terbayar = parseInt($('#terbayar').val());
        var vbayar = accounting.formatMoney(bayar, "", 0, ".", ",");
        $('#vbayar').val(vbayar);
        if (bayar > remainingpayment) {
            alert('Pembayaran melebihi sisa pembayaran');
            $('#bayar').val(remainingpayment);
            $('#vbayar').val(accounting.formatMoney(remainingpayment, "", 0, ".", ","));
        }
    });
</script>


@endsection
