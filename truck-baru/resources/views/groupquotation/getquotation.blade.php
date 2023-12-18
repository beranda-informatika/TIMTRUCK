<script src="{{ asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="table-responsive">
    <table id="example" class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
        cellspacing="0" style="border-collapse: collapse;  width: 100%;">
        <thead class="active">
            <tr>
                <th>Quotation ID</th>
                <th>Date Created</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $totalbayar = 0;
            $no = 1;
            ?>
            @foreach ($quotation as $item)
                <tr>
                    <td>{{ $item->groupquotationid }}</td>
                    <td>{{ $item->datecreated }} </td>
                    <td>{{ $item->getkategori->namakategori }}</td>

                    <td>
                        <a href="#" class="innilai">Route</button>
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
        var counter = $("table tr").index($(this).closest('tr'))-1;
        var id=table.rows[counter].cells[0].innerHTML;
        $.ajax({
            url: "{{ route('groupquotation.getroute') }}",
            type: "GET",
            dataType: 'html',
            data: {
                id: id,
            },
            success: function(data) {
                $("#tabelrate").html(data);
            }
        });
    })
</script>
