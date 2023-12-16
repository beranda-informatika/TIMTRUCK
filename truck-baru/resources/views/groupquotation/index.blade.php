@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title', 'Quotation')
@section('content')

    @include('layouts.tabel')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <a href="{{ route('groupquotation.index') }}" class="btn btn-primary mb-3">Refresh Quotation</a>
                    <a href="{{ route('groupquotation.create') }}" class="btn btn-primary mb-3">Add Quotation</a>
                    <div class="table-responsive">
                        <table id="example"
                            class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
                            cellspacing="0" style="border-collapse: collapse;  width: 100%;">

                            <thead>
                                <tr>

                                    <th scope="col">ID</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Date Created</th>


                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($groupquotation as $key)
                                    <tr>

                                        <td scope="col">{{ $key->groupquotationid }}</td>
                                        <td scope="col">{{ $key->getcustomer->namacustomer }}</td>


                                        <td>
                                            @if ($key->f_accquotation == 0)
                                                <span class="badge bg-warning">Draft</span>
                                            @endif
                                            @if ($key->f_accquotation == 1)
                                                <span class="badge bg-info">Quotation Verified</span>
                                            @endif
                                            @if ($key->f_accso == 1)
                                                <span class="badge bg-success">SO Verified</span>
                                            @endif
                                            @if ($key->f_accquotation == 1)
                                                <a href="{{ URL::to('/groupquotation/docquotation/' . $key->groupquotationid) }}"
                                                    class="btn btn-sm btn-dark"><i class="fa fa-print" aria-hidden="false">
                                                    </i></a>
                                            @endif

                                        </td>
                                        <td>
                                            <div id="kode" style="display: none">{{ $key->groupquotationid }}</div>

                                            <a href="{{ route('groupquotation.tabelrute', $key->groupquotationid) }}"
                                                class="btn btn-sm btn-primary">Route</a><i data-feather="bell"
                                                class="icon-lg"></i>
                                            @if ($key->acc > 0)
                                                <span class="badge bg-success rounded-pill">{{ $key->acc }}</span>
                                            @endif
                                            @if ($key->blmacc > 0)
                                                <span class="badge bg-danger rounded-pill">{{ $key->blmacc }}</span>
                                            @endif

                                            @if (Auth::user()->roles_id == '1' || Auth::user()->roles_id == '2')
                                                @if ($key->f_accquotation == 0)
                                                    <div class="accqts btn btn-sm btn-pink">Acc to Cust</div>
                                                @endif
                                                @if ($key->f_accquotation == 1 && $key->f_accso == 0)
                                                    <div class="accso btn btn-sm btn-success">Appr Quo</div>
                                                @endif
                                            @endif


                                        </td>
                                        <td scope="col">{{ $key->getkategori->namakategori }}</td>
                                        <td scope="col">{{ $key->datecreated }}</td>

                                        <td scope="col">


                                            @if (Auth::user()->roles_id == '1' || Auth::user()->roles_id == '2')
                                                <form
                                                    action="{{ route('groupquotation.destroy', $key->groupquotationid) }}"
                                                    method="POST">

                                                    <a href="{{ route('groupquotation.edit', $key->groupquotationid) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>

                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Hapus Data ini?');"
                                                        class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            @endif
                                            @if (Auth::user()->roles_id == '3' && $key->f_accso == 0)
                                                <form
                                                    action="{{ route('groupquotation.destroy', $key->groupquotationid) }}"
                                                    method="POST">

                                                    <a href="{{ route('groupquotation.edit', $key->groupquotationid) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>

                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Hapus Data ini?');"
                                                        class="btn btn-sm btn-danger">Hapus</button>
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


        $('.accqts').click(function() {
            var id = $(this).siblings('#kode').text();
            var confirmText = "Agree Quotations?";
            if (confirm(confirmText)) {
                $.ajax({
                    type: "post",
                    data: {
                        id: id,
                        _token: csrf
                    },
                    url: "{{ route('groupquotation.accqts') }}",
                    success: function() {
                        location.reload();

                    },
                });
            }
            return false;
        });
        $('.accso').click(function() {
            var id = $(this).siblings('#kode').text();
            var confirmText = "Acc SO?";
            if (confirm(confirmText)) {
                $.ajax({
                    type: "post",
                    data: {
                        id: id,
                        _token: csrf
                    },
                    url: "{{ route('groupquotation.accso') }}",
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
