@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title', 'Quotation')
@section('content')
    @include('sweetalert::alert')
    @include('layouts.tabel')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">



                    <div class="mb-3">
                        <label for="example-select" class="form-label">Quotation ID</label>
                        <input class="form-control" type="text" name="groupquotationid" id="groupquotationid"
                            value="{{ Session::get('groupquotationid') }}" readonly>
                    </div>

                    <div class="mb-3">

                        <label for="inputEmail3" class="col-4 col-form-label">Customer<span
                                class="text-danger">*</span></label>

                        <input class="form-control" type="text" name="kdcustomer" id="kdcustomer"
                            value="{{ $groupquotation->getcustomer->namacustomer }}" readonly>

                    </div>
                    <div class="mb-3">
                        <label for="example-select" class="form-label">Category</label>
                        <input class="form-control" type="text" name="kdkategori" id="kdkategori"
                            value="{{ $groupquotation->getkategori->namakategori }}" readonly>
                    </div>




                </div>
            </div>
        </div>
        <div class="col-lg-6">

            <div class="mb-3">

                <label for="inputEmail3" class="col-4 col-form-label">Date<span class="text-danger">*</span></label>

                <input class="form-control" type="text" name="datecreated" id="datecreated"
                    value="{{ $groupquotation->datecreated }}">

            </div>


            <div class="mb-3">
                <label for="example-text-input" class="form-label">Description</label>
                <br>
                {!! $groupquotation->description !!}


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <a href="{{ route('quotation.create') }}" class="btn btn-primary">Add Route</a>
            <a href="{{ route('groupquotation.index') }}" class="btn btn-secondary waves-effect">Back</a>
        </div>
        <div class="table-responsive">
            <table id="example" class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
                cellspacing="0" style="border-collapse: collapse;  width: 100%;">

                <thead>
                    <tr>

                        <th scope="col">No</th>
                        <th scope="col">Status</th>
                        <th scope="col">Origin</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Type Truck</th>
                        <th scope="col">Type Route</th>
                        <th scope="col">MRC</th>
                        <th scope="col">UJO</th>
                        <th scope="col">Profit/Margin</th>
                        <th scope="col">Schema UJO</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach ($rute as $key)
                        <tr>

                            <td scope="col">{{ $i }}</td>
                            <td scope="col"><span class="badge bg-danger">
                                    {{ $key->f_status }}
                                </span>
                                @if ($key->f_accquotation == 1)
                                    <span class="badge bg-info">Acc Quotation</span>
                                @endif
                                @if ($key->f_request == 1)
                                    <span class="badge bg-dark">On request</span>
                                @endif




                            </td>

                            <td scope="col">{{ $key->origin }}</td>
                            <td scope="col">{{ $key->destination }}</td>
                            <td scope="col">{{ $key->gettypetruck->namatypetruck }}</td>
                            <td scope="col">{{ $key->typeroute }}</td>

                            <td scope="col" style="text-align: right">{{ number_format($key->mrc) }}
                                @if ($key->typeroute=="load")
                                , Minimum Qty: {{ number_format($key->minqty)}}

                                @endif
                            </td>
                            <td scope="col" style="text-align: right">{{ number_format($key->ujo) }}</td>
                            <td scope="col" style="text-align: right">
                                @if ($key->typeroute=="load")
                                {{ number_format(($key->mrc * $key->minqty)- $key->ujo) }}
                                @else
                                {{ number_format($key->mrc- $key->ujo) }}
                                @endif
                            </td>
                            <td scope="col">
                                <div id="kode" style="display: none">{{ $key->id }}</div>
                                @if (Auth::user()->roles_id == '1' || Auth::user()->roles_id == '2')
                                    <a href="{{ route('quotation.inujo', $key->id) }}"
                                        class="btn btn-sm btn-primary">Schema
                                        UJO</a>
                                @endif
                                @if (Auth::user()->roles_id == '3')
                                    @if ($key->f_accquotation == 1 && $key->f_request == 0)
                                        <a href="{{ route('quotation.requestujo', $key->id) }}"
                                            class="btn btn-sm btn-dark requestujo">Request Edit</a>
                                    @endif
                                @endif
                                @if (Auth::user()->roles_id == '3' && $key->f_accquotation == 0)
                                    <a href="{{ route('quotation.inujo', $key->id) }}"
                                        class="btn btn-sm btn-primary">Schema
                                        UJO</a>
                                @endif
                                @if (Auth::user()->roles_id == '1' || Auth::user()->roles_id == '2')
                                    @if ($key->f_accquotation == 0)
                                        <div class="accqts btn btn-sm btn-pink">Acc Shema UJO</div>
                                    @endif
                                    @if ($key->f_request == 1)
                                        <div class="accrequest btn btn-sm btn-dark">Acc Request </div>
                                    @endif
                                @endif


                            </td>


                            <td scope="col">
                                @if (Auth::user()->roles_id == '1' || Auth::user()->roles_id == '2')
                                    <form action="{{ route('quotation.destroy', $key->id) }}" method="POST">
                                        @csrf
                                        <a href="{{ route('quotation.edit', $key->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure to delete?');"
                                            class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endif
                                @if (Auth::user()->roles_id == '3')
                                    @if ($key->f_accquotation == 0)
                                        <form action="{{ route('quotation.destroy', $key->id) }}" method="POST">
                                            @csrf
                                            <a href="{{ route('quotation.edit', $key->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>


                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure to delete?');"
                                                class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>

        var csrf = $('meta[name="csrf-token"]').attr('content');
        $('.requestujo').click(function() {
            var id = $(this).siblings('#kode').text();
            var confirmText = "Request Update Schema UJO?";
            if (confirm(confirmText)) {
                $.ajax({
                    type: "post",
                    data: {
                        id: id,
                        _token: csrf
                    },
                    url: "{{ route('quotation.requestujo') }}",
                    success: function() {
                        location.reload();

                    },
                });
            }
            return false;
        });

        $('.accqts').click(function() {
            var id = $(this).siblings('#kode').text();
            var confirmText = "Agree Schema UJO?";
            if (confirm(confirmText)) {
                $.ajax({
                    type: "post",
                    data: {
                        id: id,
                        _token: csrf
                    },
                    url: "{{ route('quotation.accqts') }}",
                    success: function() {
                        location.reload();

                    },
                });
            }
            return false;
        });
        $('.accrequest').click(function() {
            var id = $(this).siblings('#kode').text();
            var confirmText = "Open Request Schema UJO?";
            if (confirm(confirmText)) {
                $.ajax({
                    type: "post",
                    data: {
                        id: id,
                        _token: csrf
                    },
                    url: "{{ route('quotation.accrequest') }}",
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
