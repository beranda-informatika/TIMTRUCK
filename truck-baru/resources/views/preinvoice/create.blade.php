@extends('layouts.master')
@section('css')




    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">



@endsection
@section('title', 'Sales Order')
@section('content')
@include('sweetalert::alert')





    <div class="row">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Pre Invoice</h4>
            </div>

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
                <form id="salesorder" method="POST">


                    <table class="table table-responsive">
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
    <div id="tabeldata"></div>


    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $(document).on('submit', '#salesorder', function() {
            $.ajax({
                url: "{{ route('preinvoice.getsalesorder') }}",
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
    <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ URL::asset('build/js/pages/datatable-pages.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
@endsection
