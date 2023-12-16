<script src="{{ asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="table-responsive">
    <input type="hidden" id="kdcustomer" name="kdcustomer" class="form-control" value="{{ $kdcustomer }}" readonly>
    <table id="example" class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
        cellspacing="0" style="border-collapse: collapse;  width: 100%;">
        <thead class="active">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Origin</th>
                <th scope="col">Destination</th>
                <th scope="col">Type Truck</th>
                <th scope="col">MRC</th>
                <th>action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $totalbayar = 0;
            $no = 1;
            ?>
            @foreach ($quotation as $key)
                <tr>
                    <td scope="col">{{ $key->id }}</td>
                    <td scope="col">{{ $key->origin }}</td>
                    <td scope="col">{{ $key->destination }}</td>
                    <td scope="col">{{ $key->gettypetruck->namatypetruck }}</td>
                    <td scope="col">{{ number_format($key->mrc) }}</td>
                    <td>
                        <div id="kode" style="display: none">{{ $key->id }}</div>
                        <input type="hidden" id="aksi" name="aksi" class="form-control" value="{{ $aksi }}" readonly>
                        <input type="hidden" id="shipmentid" name="shipmentid" class="form-control" value="{{ $shipmentid }}" readonly>

                        <a href="#" class="innilai">Choose</button>
                    </td>
                </tr>
                <?php $no++; ?>
            @endforeach
    </table>
</div>
<script>
      var csrf = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        $('#example').DataTable({
            "scrollX": true,
            "searching": true,
        });
    });

    $('.innilai').click(function() {
        var id = $(this).siblings('#kode').text();

        $.ajax({
            type: "post",
            data: {
                id: id,
                kdcustomer: $("#kdcustomer").val(),
                aksi: $("#aksi").val(),
                shipmentid: $("#shipmentid").val(),
                _token: csrf
            },
            dataType: "html",
            url: "{{ route('groupquotation.setroute') }}",
            success: function(data) {
                $("#formmarketing").html(data);
            },
        });
    })
</script>
