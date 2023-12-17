<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example"
                        class=" nowrap table table-striped table-bordered scroll-horizontal font-size-11" cellspacing="0"
                        style="border-collapse: collapse;  width: 100%;">

                        <thead>
                            <tr>

                                <th scope="col">shipment ID</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Status</th>

                                <th scope="col">Quotation ID</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Tgl Request</th>
                                <th scope="col">Origin</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Type Route</th>
                                <th scope="col">MRC</th>
                                <th scope="col">UJO</th>
                                <th scope="col">Multi Drop</th>
                                <th scope="col">Multi Pickup</th>
                                <th scope="col">Description</th>
                                <th scope="col">Sales</th>
                                <th scope="col">Type Truck</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Driver</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp

                            @foreach ($shipment as $key)
                                <tr>

                                    <td scope="col">{{ $key->shipmentid }}</td>
                                    <td scope="col">{{ $key->getcustomer->namacustomer }}</td>
                                    <td scope="col"><span class="badge bg-danger">
                                            {{ $key->f_status }}
                                        </span>

                                    </td>


                                    <td>{{ $key->groupquotationid }}</td>
                                    <td scope="col">{{ $key->kdkategori }}</td>
                                    <td scope="col">{{ $key->tglorder }}</td>
                                    <td scope="col">{{ $key->origin }}</td>
                                    <td scope="col">{{ $key->destination }}</td>
                                    <td scope="col">{{ $key->typeroute }}</td>
                                    <td scope="col" style="text-align: right">
                                        @if (Auth::user()->roles_id == 1 ||
                                                Auth::user()->roles_id == 2 ||
                                                Auth::user()->roles_id == 3 ||
                                                Auth::user()->roles_id == 4)
                                            @if ($key->typeroute == 'load')
                                                {{ number_format($key->unitmrc) }}
                                            @else
                                                {{ number_format($key->mrc) }}
                                            @endif
                                        @endif
                                    </td>
                                    <td scope="col" style="text-align: right">
                                       @if($key->getujo!=null)
                                        {{ $key->getujo->noujo }}
                                        @else 
                                        ujo not yet defined
                                        @endif
                                    </td>
                                    <td>
                                        @if ($key->multidrop == 1)
                                            {{ $key->qtydrop }} point
                                        @endif
                                    </td>
                                    <td>
                                        @if ($key->multipickup == 1)
                                            {{ $key->qtypickup }} point
                                        @endif
                                    </td>
                                    <td scope="col">{{ $key->description }}</td>


                                    <td scope="col">{{ $key->getsales->namasales }}</td>


                                    <td scope="col">{{ $key->gettypetruck->namatypetruck }}</td>

                                    <td scope="col">
                                        @if ($key->kdunit != null)
                                            {{ $key->getunit->plat }}
                                        @endif
                                    </td>
                                    <td scope="col">
                                        @if ($key->kddriver != null)
                                            {{ $key->getdriver->namadriver }}
                                        @endif
                                    </td>

                                    <td>
                                        <form action="{{ route('ujo.formujo', $key->shipmentid) }}" method="GET">
                                            <input type=hidden name="shipmentid" value="{{ $key->shipmentid }}">
                                            <button type="submit">Choose</button>
                                        </form>
                                        <div id="kode" style="display: none">{{ $key->shipmentid }}</div>

                                        @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2)
                                            <form action="{{ route('shipment.destroy', $key->shipmentid) }}"
                                                method="POST">



                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Hapus Data ini?');"
                                                    class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        @endif

                                        @if (Auth::user()->roles_id == 3 && $key->f_status == 'New' && $key->f_operational == 0)
                                            <form action="{{ route('shipment.destroy', $key->shipmentid) }}"
                                                method="POST">
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
    $('.accshipment').click(function() {
        var id = $(this).siblings('#kode').text();
        var confirmText = "Acc Sales Order?";
        if (confirm(confirmText)) {
            $.ajax({
                type: "post",
                data: {
                    id: id,
                    _token: csrf
                },
                url: "",
                success: function() {
                    location.reload();

                },
            });
        }
        return false;
    });
    $('.accarrival').click(function() {
        var id = $(this).siblings('#kode').text();
        var confirmText = "Acc shipment?";
        if (confirm(confirmText)) {
            $.ajax({
                type: "post",
                data: {
                    id: id,
                    _token: csrf
                },
                url: "",
                success: function() {
                    location.reload();

                },
            });
        }
        return false;
    });
</script>
