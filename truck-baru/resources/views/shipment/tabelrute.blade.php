<script src="{{ asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="table-responsive">
    <table id="example" class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
        cellspacing="0" style="border-collapse: collapse;  width: 100%;">
        <thead class="active">
            <tr>
                <th>Route ID</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Rute</th>
                <th>MRC</th>

                <th>action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $totalbayar = 0;
            $no = 1;
            ?>
            @foreach ($rute as $itemrute)
                <tr>
                    <td>{{ $itemrute->routeid }}</td>
                    <td>{{ $itemrute->origin }} </td>
                    <td>{{ $itemrute->destination }}</td>
                    <td>{{ $itemrute->route }}</td>
                    <td style="text-align: right">{{ $itemrute->mrc }}</td>    
                    <td> <div id="baris" style="display: none"><?php echo $no; ?></div>
                    <a href="#" class="innilai">Pilih</button>
                    </td>
                </tr>
                <?php $no++; ?>
            @endforeach
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "scrollX": true,
            "searching": true,
        });
    });

    $('.innilai').click(function() {
        var table = document.getElementById("example");
        var counter = $(this).closest('tr').find('#baris').text();
        var mrc=table.rows[counter].cells[4].innerHTML;
        $('#mrc').val(mrc);
        tampilnominal();
    })
</script>
