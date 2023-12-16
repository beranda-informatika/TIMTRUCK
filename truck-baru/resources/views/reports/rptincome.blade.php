@extends('layouts.master')
@section('css')




    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">



@endsection
@section('title', 'Reports Income Statement')
@section('content')





    <div class="row">
        <div class="card">

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="rptincome" method="POST">


                    <table class="table table-responsive">
                        <tr>
                            <td>Period Report (Date Order)</td>
                            <td>
                                <input type="date" name="tglmulai" id="inputTglmulai" value="" required="required"
                                    title=""> s/d <input type="date" name="tglakhir" id="inputTglmulai"
                                    value="" required="required" title="">
                        </tr>

                        <tr>
                            <td>Customer</td>
                            <td>
                                <select name="kdcustomer" id="kdcustomer" required class="form-control"></select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" class="btn btn-primary">Open</button>

                        </tr>

                    </table>
                </form>
            </div>

        </div>
    </div>
    @include('layouts.tabel')
    <div id="tabeldata" class="table-responsive"></div>


    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $(document).on('submit', '#rptincome', function() {
            $.ajax({
                url: "{{ route('report.income') }}",
                type: "GET",
                dataType: 'html',
                data: $(this).serialize(),
                success: function(data) {
                    $("#tabeldata").html(data);
                }
            });
            return false;
        });
        $("#kdcustomer").select2({
            placeholder: 'select Customer',
            ajax: {
                url: "{{ route('customer.getcustomer') }}",
                type: "GET",
                dataType: 'JSON',
                delay: 250,
                data: function(params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term,
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
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
