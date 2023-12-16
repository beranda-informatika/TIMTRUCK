<div class="row">

    <div class="col-12">
        <a href="{{ route('preinvoice.create') }}" class="btn btn-primary">Create Preinvoice</a>
        <br>
        <br>

        <div class="table-responsive">
            <table id="example" class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
                cellspacing="0" style="border-collapse: collapse;  width: 100%;">

                <thead>
                    <tr>
                        <th scope="col">Preinvoice No</th>
                        <th scope="col">Customer</th>

                        <th scope="col">Project</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Status</th>
                        <th scope="col">Act</th>


                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp

                    @foreach ($preinvoice as $key)
                        <tr>
                            <td>{{ $key->piid }}
                            </td>

                            <td scope="col">{{ $key->getcustomer->namacustomer }}</td>

                            <td scope="col">{{ $key->project }}</td>
                            <td scope="col">{{ $key->datecreate }}</td>
                            <td scope="col"><span class="badge bg-danger">
                                    {{ $key->f_status }}
                                </span>
                                <a href="{{ URL::to('/preinvoice/pdfpreinvoice/' . $key->piid) }}"
                                    class="btn btn-sm btn-dark"  target="_blank"><i class="fa fa-print" aria-hidden="false">
                                    </i></a>
                            </td>
                            <td>
                                <div id="kode" style="display: none">{{ $key->piid }}</div>
                                @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2 || Auth::user()->roles_id == 5)
                                    <form action="{{ route('preinvoice.delete', $key->piid) }}" method="POST">

                                        <a href="{{ route('preinvoice.edit', $key->piid) }}"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus Data ini?');"
                                            class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
<script>
    var csrf = $('meta[name="csrf-token"]').attr('content');
    $(document).on('click', '.entry', function() {
        var id = $(this).siblings('#kode').text();
        $.ajax({
            type: "get",
            data: {
                id: id,
                _token: csrf
            },
            url: "{{ route('shipment.formoperational') }}",
            success: function(data) {
                $("#tabeldata").html(data);
            }
        });
        return false;


    });

</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'print'
            ]
        });

    } );
    </script>
