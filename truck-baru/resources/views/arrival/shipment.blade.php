<table id="datatable" class="table table-striped nowrap">

    <thead>
        <tr>

            <th scope="col">No.ID</th>
            <th scope="col">Route</th>
            <th scope="col">Project</th>
            <th scope="col">Customer</th>
            <th scope="col">Sales</th>
            <th scope="col">Driver</th>
            <th scope="col">Unit</th>

            <th scope="col">Tgl.Quotation</th>
            <th scope="col">Status</th>

            <th scope="col">Action</th>
            <th scope="col">Action</th>

        </tr>
    </thead>
    <tbody>
        @php $i=1; @endphp
        @foreach ($shipment as $key)
            <tr>
                <td scope="col">{{ $key->shipmentid }}</td>
                <td scope="col">{{ $key->getrute->route }}</td>
                <td scope="col">{{ $key->getrute->getproject->namaproject }}</td>
                <td scope="col">{{ $key->getcustomer->namacustomer }}</td>
                <td scope="col">{{ $key->getsales->namasales }}</td>
                <td scope="col">{{ $key->getdriver->namadriver }}</td>
                <td scope="col">{{ $key->getunit->plat }}</td>

                <td scope="col">{{ $key->tglquotation }}</td>
                <td scope="col">
                   @include('statusshipment.statusshipment')


                </td>


                <td scope="col">



                    <a href="{{ route('arrival.formapprove', $key->shipmentid) }}" class="btn btn-sm btn-warning">Open
                        Data</a>

                    @csrf

                </td>

                <td scope="col">


                    <form action="{{ route('shipment.destroy', $key->shipmentid) }}" method="POST">


                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus Data ini?');"
                            class="btn btn-sm btn-danger">Del</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
