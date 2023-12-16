@foreach ($quotation as $item)
    <table class="table table-bordered mb-0" style="text-align: left; font-size: 12px">
        <thead>

            <tr class="table-danger">
                <th scope="col">Rate Id</th>
                <th scope="col">Nama Rate</th>
                <th scope="col">Jumlah</th>

            </tr>
        </thead>
        <tbody>
            <form>
                <?php $i = 0;
                $total = 0; ?>
                @foreach ($item->get_detailrate as $data)
                    <tr>
                        <td width="3%">
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
                            <input class="innilai" type="text" name="jumlah[]" id="jumlah{{ $i }}"
                                value="{{ $data->jumlah }}"
                                style="text-align: right; width: 100px; background:rgb(239, 237, 237)" readonly
                                required>

                        </td>

                    </tr>
                    <?php $i++; ?>
                @endforeach






        </tbody>
    </table>
@endforeach


<script>
    function total() {
        var x = {{ count($item->get_detailrate) }};
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
