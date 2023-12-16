@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('title', 'Quotation')
@section('content')

    @include('layouts.tabel')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <a href="{{ route('quotation.index') }}" class="btn btn-primary mb-3">Refresh Quotation</a>
                    <a href="{{ route('quotation.create') }}" class="btn btn-primary mb-3">Tambah Quotation</a>
                    <div class="table-responsive">
                        <table id="example"
                            class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
                            cellspacing="0" style="border-collapse: collapse;  width: 100%;">

                            <thead>
                                <tr>

                                    <th scope="col">ID</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>

                                    <th scope="col">Tgl Request</th>
                                    <th scope="col">Origin</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">MRC</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Customer</th>

                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($quotation as $key)
                                    <tr>

                                        <td scope="col">{{ $key->id }}</td>

                                        <td><span class="badge bg-danger">
                                            {{ $key->f_status }}
                                        </span>
                                        @if($key->f_accquotation == 1)
                                        <span class="badge bg-info">Acc Quotation</span>
                                        @endif
                                        @if($key->f_accso == 1)
                                            <span class="badge bg-success">Acc SO</span>
                                        @endif
                                        </td>
                                        <td>
                                            @if($key->f_accquotation == 1)

                                            <a href="{{ URL::to('/quotation/docquotation/' . $key->id) }}"
                                            class="btn btn-sm btn-secondary"><i class="fa fa-print" aria-hidden="false">
                                                    Quotation </i></button></a>
                                            @endif
                                        </td>

                                        <td scope="col">{{ $key->tglrequest }}</td>
                                        <td scope="col">{{ $key->origin }}</td>
                                        <td scope="col">{{ $key->destination }}</td>
                                        <td scope="col">{{ number_format($key->mrc) }}</td>
                                        <td scope="col">{{ $key->description }}</td>

                                        <td scope="col">{{ $key->getcustomer->namacustomer }}</td>


                                        <td scope="col">

                                            <form action="{{ route('quotation.destroy', $key->id) }}" method="POST">
                                                <a href="{{ route('quotation.edit', $key->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Hapus Data ini?');"
                                                    class="btn btn-sm btn-danger">Hapus</button>
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
