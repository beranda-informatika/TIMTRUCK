@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title', 'shipment')
@section('content')

    @include('layouts.tabel')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <a href="{{ route('shipment.index') }}" class="btn btn-primary mb-3">Refresh shipment</a>
                    <div class="table-responsive">
                        <table id="example"
                            class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
                            cellspacing="0" style="border-collapse: collapse;  width: 100%;">

                            <thead>
                                <tr>

                                    <th scope="col">shipment ID</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Quotation ID</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Tgl Request</th>
                                    <th scope="col">Origin</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">MRC</th>
                                    <th scope="col">UJO</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Sales</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Type Truck</th>
                                    <th scope="col">Driver</th>
                                    <th scope="col">Act</th>


                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp

                                @foreach ($shipment as $key)
                                    <tr>

                                        <td scope="col">{{ $key->shipmentid }}</td>
                                        <td scope="col"><span class="badge bg-danger">
                                                {{ $key->f_status }}
                                            </span>

                                        </td>

                                        <td scope="col">
                                            <div id="kode" style="display: none">{{ $key->id }}</div>

                                            <a href="{{ route('shipment.inujo', $key->shipmentid) }}"
                                                class="btn btn-sm btn-primary">UJO</a>
                                            <a href="{{ route('shipment.edit', $key->shipmentid) }}"
                                                class="btn btn-sm btn-warning">Edit</a>


                                        </td>
                                        <td>{{ $key->quotationid }}</td>
                                        <td scope="col">{{ $key->getkategori->namakategori }}</td>
                                        <td scope="col">{{ $key->tglorder }}</td>
                                        <td scope="col">{{ $key->origin }}</td>
                                        <td scope="col">{{ $key->destination }}</td>
                                        <td scope="col" style="text-align: right">{{ number_format($key->mrc) }}</td>
                                        <td scope="col" style="text-align: right">{{ number_format($key->ujo) }}</td>
                                        <td scope="col">{{ $key->description }}</td>

                                        <td scope="col">{{ $key->getcustomer->namacustomer }}</td>
                                        <td scope="col">{{ $key->getsales->namasales }}</td>
                                        <td scope="col">{{ $key->getunit->plat }}</td>

                                        <td scope="col">{{ $key->gettypetruck->namatypetruck }}</td>
                                        <td scope="col">{{ $key->getdriver->namadriver }}</td>

                                        <td>
                                            <form action="{{ route('shipment.destroy', $key->shipmentid) }}"
                                            method="POST">

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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
       var csrf = $('meta[name="csrf-token"]').attr('content');

        $('.accshipment').click(function() {
           var id= $(this).siblings('#kode').text();
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
           var id= $(this).siblings('#kode').text();
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
@endsection
@section('script')

    <!-- Required datatable js -->
    <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ URL::asset('build/js/pages/datatable-pages.init.js') }}"></script>
    <!-- Buttons examples -->
    {{-- <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script> --}}
    <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    {{-- <script src="{{ URL::asset('build/libs/pdfmake/vfs_fonts.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
</script> --}}

    <!-- Datatable init js -->
    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
@endsection
