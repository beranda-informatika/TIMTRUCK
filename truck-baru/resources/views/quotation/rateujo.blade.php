<table class="table table-bordered mb-0 " style="text-align: left; font-size: 10px">
    <thead>

        <tr class="table-danger">
            <th >Rate Id</th>
            <th >Nama Rate</th>
            <th >Nominal</th>
            {{-- <th scope="col">Qty</th>
            <th scope="col">Jumlah</th>
            <th scope="col">pph (%)</th>
            <th scope="col">Amount PPh</th> --}}

        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        $total = 0; ?>
        @if (count($detailrate) > 0)
            @foreach ($detailrate as $data)
                <tr>
                    <td>
                        <input type="hidden" name="idratequotation[]" id="idratequotation{{ $i }}" value="{{ $data->id }}"
                        readonly style="text-align: left; background:rgb(239, 237, 237) ">
                        <div id="kode" style="display:none"><?php echo $i; ?></div>
                        <div id="f_invoice" style="display:none"><?php echo $data->f_invoice; ?></div>
                        <input type="hidden" name="rateid[]" id="rateid{{ $i }}" value="{{ $data->rateid }}"
                            readonly style="text-align: left;  background:rgb(239, 237, 237) ">
                        {{ $data->rateid }}
                        
                    </td>
                    <td >
                        <input type="hidden" name="namarate[]" id="namarate{{ $i }}"
                            value="{{ $data->getrate->namarate }}"
                            style="text-align: left; width: 100px; background:rgb(239, 237, 237)" require readonly>
                        {{ $data->getrate->namarate }}
                    </td>

                    <td  style="text-align: right;">
                        <input class="innilai" type="text" name="nominal[]" id="nominal{{ $i }}"
                            value="{{ $data->nominal }}" style="text-align: right; width: 75px">
                            <input class="innilai" type="number" name="qty[]" id="qty{{ $i }}"
                            value="{{ $data->qty }}" style="text-align: right; width: 30px; display:none" >

         
                  
                        <input class="innilai" type="text" name="jumlah[]" id="jumlah{{ $i }}"
                            value="{{ $data->jumlah }}" style="text-align: right; width: 75px; display:none" readonly required >

         
                
                        <input class="inpph" type="text" name="pph[]" id="pph{{ $i }}"
                            value="{{ $data->pph }}" max="100" style="text-align: right; width: 25px; display:none" >

               
                        <input type="text" name="pajak[]" id="pajak{{ $i }}" value="{{ $data->pajak }}"
                            style="text-align: right; width: 60px; display:none" readonly >
                    </td>

             
                       

 

                </tr>

                <?php $i++; ?>
            @endforeach
        @else
            @foreach ($rate as $data)
                <tr>
                    <td>
                        <input type="hidden" name="idratequotation[]" id="idratequotation{{ $i }}" value=""
                        readonly style="text-align: left;  background:rgb(239, 237, 237) ">
                        <input type="hidden" name="rateid[]" id="rateid{{ $i }}"
                            value="{{ $data->rateid }}" readonly
                            style="text-align: left;  background:rgb(239, 237, 237) ">
                        {{ $data->rateid }}
                        <div id="kode" style="display:none"><?php echo $i; ?></div>
                        <div id="f_invoice" style="display:none"><?php echo $data->f_invoice; ?></div>
                    </td>
                    <td >
                        <input type="hidden" name="namarate[]" id="namarate{{ $i }}"
                            value="{{ $data->namarate }}"
                            style="text-align: left; width: 100px; background:rgb(239, 237, 237)" require readonly>
                        {{ $data->namarate }}
                    </td>

                    <td  style="text-align: right;">
                        <input class="innilai" type="text" name="nominal[]" id="nominal{{ $i }}"
                            value="0" style="text-align: right; width: 75px">
                            <input class="innilai" type="number" name="qty[]" id="qty{{ $i }}" value="1"
                            style="text-align: right; width: 30px; display:none">

                        <input class="innilai" type="text" name="jumlah[]" id="jumlah{{ $i }}"
                        value="0"  style="text-align: right; width: 75px; display:none" readonly required>

                
                    
                        <input class="inpph bg-info" type="text" name="pph[]" id="pph{{ $i }}"
                            value="{{ $data->persenpajak }}" max="100" style="text-align: right; width: 25px; display:none" readonly>

                 
                  
                        <input type="text" name="pajak[]" id="pajak{{ $i }}" value="0"  class="bg-success"
                            style="text-align: right; width: 60px; display:none" readonly>
                    </td>

                
                       

                

                </tr>
                <?php $i++; ?>
            @endforeach
        @endif
                <tr>
                    <td colspan="2" style="text-align: right; font-weight: bold">Total UJO</td>
                    <td  style="text-align: right">
                        <input type="hidden" name="totalujo" id="totalujo" style="text-align: right" >
                        <input type="text" name="vtotalujo" id="vtotalujo" style="text-align: right; color:yellow" readonly class="bg-primary">

                    </td>
                </tr>





    </tbody>
</table>


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
