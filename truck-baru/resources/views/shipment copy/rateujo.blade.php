<table class="table table-bordered mb-0 " style="text-align: left; font-size: 10px">
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
        <?php $i = 0;
        $total = 0; ?>

        @foreach ($detailrate as $data)
            <tr @if ($data->f_edit == '0') style=" background:rgb(239, 237, 237); "  readonly
            @endif
               >
                <td>
                    <input type="hidden" name="idratequotation[]" id="idratequotation{{ $i }}"
                        value="{{ $data->id }}" readonly
                        style="text-align: left; width: 50px; background:rgb(239, 237, 237) ">

                    <input type="hidden" name="rateid[]" id="rateid{{ $i }}" value="{{ $data->rateid }}"
                        readonly style="text-align: left; width: 50px; background:rgb(239, 237, 237) ">
                    {{ $data->rateid }}
                    <div id="kode" style="display:none"><?php echo $i; ?></div>
                </td>
                <td width="15%">
                    <input type="hidden" name="namarate[]" id="namarate{{ $i }}"
                        value="{{ $data->getrate->namarate }}"
                        style="text-align: left; width: 100px; background:rgb(239, 237, 237)" require readonly>
                    {{ $data->getrate->namarate }}
                </td>

                <td style="text-align: right;">
                    <input class="innilai" type="text" name="nominal[]" id="nominal{{ $i }}"
                        value="{{ $data->nominal }}"
                        @if ($data->f_edit == '0') style="text-align: left; width: 75px; background:rgb(239, 237, 237);  text-align:right" require readonly
                        @else

                        style="text-align: right; width: 75px" @endif
                        @if ($data->f_invoice == '1') style="text-align: left; width: 75px; background:rgb(3, 120, 62);  text-align:right" require readonly
                        @else

                        style="text-align: right; width: 75px" @endif

                        >
                </td>

                <td style="text-align: right;">
                    <input class="innilai" type="number" name="qty[]" id="qty{{ $i }}"
                        value="{{ $data->qty }}" @if ($data->f_edit == '0') style="text-align: left; width: 40PX; background:rgb(239, 237, 237);  text-align:right" require readonly
                        @else

                        style="text-align: right; width: 40PX" @endif
                        @if ($data->f_invoice == '1') style="text-align: left; width: 75px; background:rgb(131, 35, 35);  text-align:right" require readonly
                        @else

                        style="text-align: right; width: 75px" @endif
                        >

                </td>
                <td style="text-align: right;">
                    <input class="innilai" type="text" name="jumlah[]" id="jumlah{{ $i }}"
                        value="{{ $data->jumlah }}"
                        @if ($data->f_edit == '0')
                            style="text-align: left; width: 75px; background:rgb(239, 237, 237);  text-align:right" require readonly
                        @else
                        style="text-align: right; width: 75px" @endif

                        readonly required>

                </td>
                <td style="text-align: right;">
                    <input class="inpph" type="text" name="pph[]" id="pph{{ $i }}"
                        value="{{ $data->pph }}" max="100"
                        @if ($data->f_edit == '0') style="text-align: left; width: 25px; background:rgb(239, 237, 237);  text-align:right" require readonly
                        @else

                        style="text-align: right; width: 72px" @endif>


                </td>
                <td style="text-align: right;">
                    <input type="text" name="pajak[]" id="pajak{{ $i }}" value="{{ $data->pajak }}"
                    @if ($data->f_edit == '0') style="text-align: left; width: 60PX; background:rgb(239, 237, 237);  text-align:right" require readonly
                    @else

                    style="text-align: right; width: 60PX" @endif readonly>

                </td>

            </tr>
            <?php $i++; ?>
        @endforeach

        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold">Total UJO</td>
            <td colspan="3" style="text-align: right">
                <input type="hidden" name="totalujo" id="totalujo" style="text-align: right">
                <input type="text" name="vtotalujo" id="vtotalujo" style="text-align: right; color:yellow" readonly
                    class="bg-primary">

            </td>
        </tr>





    </tbody>
</table>
<div style="text-align: right; padding:10px">
    <div class="btn btn-sm btn-info  btn-action"
    data-url="{{ route('shipment.inrate',$shipment->shipmentid) }}"
    id="btnAction1">Add Rate</div>
</div>

<script>
    $(document).ready(function() {
        total();
    });

    function total() {
        var x = {{ $jmlitem }};
        var total = 0;
        for (i = 0; i < x; i++) {
            var jumlah = parseInt($("#jumlah" + i).val());
            if (isNaN(jumlah)) {
                jumlah = 0;
            }
            total = total + jumlah;
        }
        $("#totalujo").val(total);
        $("#vtotalujo").val(accounting.formatMoney(total, "Rp. ", 0, ".", ","));


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
            var pph = $("#pph" + counter).val();
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
