@extends('layouts.master')

@section('title') User List @endsection

@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<!-- start page title -->
@component('components.breadcrumb')
@slot('li_1') Contacts @endslot
@slot('title') User Log History @endslot
@endcomponent
@include('sweetalert::alert')
<div class="row align-items-center">
<div class="content-wrapper">



    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-hover" id="tabelku" style="font-size: 11px;">
                        <thead>
                            <tr class="active">
                                <th width="1%">No</th>
                                <th>Email</th>
                                <th>last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;?>
                            @foreach ($logs as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>Email: {{ $row->email }}</td>
                                <td>{{ $row->created_at}}</td>                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
    </section>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#tabelku').DataTable();
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