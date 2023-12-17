<div class="container">
    <form id="add-rate-form">
        @csrf
        <div class="form-group">
            <label for="kdbarang">No Ujo </label>
            <input type="text" class="form-control" id="noujo" name="noujo" value="{{ $id }}" readonly>
        </div>
        <div class="form-group">
            <label for="kdbarang">Rate </label>
            <select class="form-control" id="inrateid" name="inrateid" required>
                <option value="">Pilih Rate</option>
                @foreach ($rate as $item)
                <option value="{{ $item->rateid }}">{{ $item->namarate }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="kdbarang">Nominal </label>
            <input type="text" class="form-control" id="innominal" name="innominal" value="" required>
        </div>
        <div class="form-group">
            <label for="kdbarang">Qty </label>
            <input type="text" class="form-control" id="inqty" name="inqty" value="1" required>
        </div>
        <div class="form-group">
            <label for="kdbarang">Jumlah </label>
            <input type="text" class="form-control" id="injumlah" name="injumlah" value="" readonly>
        </div>
        <div class="form-group">
            <label for="kdbarang">Keterangan </label>
            <input type="text" class="form-control" id="indescript" name="indescript" value="">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
<script>
    $(document).ready(function () {
        $("#innominal").focus();
        $('#innominal').keyup(function () {
            var nominal= $('#innominal').val();
            var qty = $('#inqty').val();

            var jumlah = nominal*qty;
            $('#injumlah').val(jumlah);
        });
        $('#inqty').keyup(function () {
            var nominal= $('#innominal').val();
            var qty = $('#inqty').val();

            var jumlah = nominal*qty;
            $('#injumlah').val(jumlah);
        });
    });
    $("#add-rate-form").submit(function(event){
        event.preventDefault();
         $.ajax({
              url: "/ujo/ratestore",
              type:"POST",
              data:
              {
                'noujo': $('#noujo').val(),
                'routeid': $('#inrouteid').val(),
                'rateid': $('#inrateid').val(),
                'descript' : $('#indescript').val(),
                'nominal': $('#innominal').val(),
                'qty': $('#inqty').val(),
                'jumlah': $('#injumlah').val(),
                'pph' : 0,
                'pajak' : 0,
                '_token': $('input[name=_token]').val()

              },
              success: function(response){
                alert(response.message);
                $('#myModal').modal('hide');
                $('.modal-backdrop').hide();
                location.reload();


              },

              });
          });


</script>
