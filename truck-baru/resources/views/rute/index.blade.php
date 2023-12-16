@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@section('title', 'rute')
@include('layouts.tabel')
<div class="row">

    <div class="col-12">
        <div id="myModal" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
        <div class="card">

            <div class="card-body">
                <a href="{{ route('rute.index') }}" class="btn btn-primary mb-3">Refresh rute</a>
                <div class="table-responsive">
                    <table id="example"
                    class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
                    cellspacing="0" style="border-collapse: collapse;  width: 100%;">
                    <thead>
                        <tr>

                            <th scope="col">route id</th>
                            <th scope="col">Origin</th>
                            <th scope="col">Destination</th>
                            <th scope="col">Customer</th>
                            
                            <th scope="col">Type Truck</th>
                            <th scope="col">Type Route</th>
                            <th scope="col">Description</th> 

                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach ($rute as $key)
                            <tr>

                                <td scope="col">{{ $key->id }}</td>
                                <td scope="col">{{ $key->origin }}</td>
                                <td scope="col">{{ $key->destination }}</td>
                                <td scope="col">{{ $key->getgroupquotation->getcustomer->namacustomer }}</td>
                                
                                <td scope="col">{{ $key->gettypetruck->namatypetruck }}</td>
                                <td scope="col">{{ $key->typeroute }}</td>
                                <td scope="col">{{ $key->description }}</td>

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
    $('.btn-action').click(function() {
        var url = $(this).data("url");

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(res) {

                // get the ajax response data
                var data = res;

                // update modal content here
                // you may want to format data or
                // update other modal elements here too
                $('.modal-body').html(data);

                // show modal
                $('#myModal').modal('show');

            },
            error: function(request, status, error) {
                console.log("ajax call went wrong:" + request.responseText);
            }
        });
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

