@extends('layouts.master')
@section('css')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

@section('title', 'Shipment')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Sales Order</h4>
                <p class="sub-header">
                    Form Shipment Sales Order
                </p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Ada kesalahan input data! <br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
               
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">

                                <label for="inputEmail3" class="col-4 col-form-label">Customer<span
                                        class="text-danger">*</span></label>

                                <select name="kdcustomer" id="kdcustomer" required class="form-control"></select>


                            </div>
                            <div class="mb-3">
                            <div class="btn btn-sm btn-primary" id="btncari">Open Quotations</div>
                            <div class="btn btn-sm btn-primary" id="btncariroute">Open Route</div>
                            </div>
                            <div class="mb-3">
                                <div id="tabelrate"></div>
                            </div>


                        </div> <!-- end col -->

                        <div class="col-lg-6">
                            <div id="formmarketing"></div>
                        </div> <!-- end col -->
                    </div>


       
                <!-- end row-->

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
<script>

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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
    
    $("#btncari").click(function() {
        pilihquotation();
    });
    $("#btncariroute").click(function() {
        pilihrouteall();
    });


    function pilihquotation() {
        var quotationid = $("#kdcustomer").val();
        $.ajax({
            url: "{{ route('groupquotation.getquotation') }}",
            type: "GET",
            dataType: 'html',
            data: {
                id: quotationid,
                
            },
            success: function(data) {
                $("#tabelrate").html(data);
            }
        });
    }
    function pilihrouteall() {
        var quotationid = $("#kdcustomer").val();
        $.ajax({
            url: "{{ route('groupquotation.getrouteall') }}",
            type: "GET",
            dataType: 'html',
            data: {
                id: quotationid,
            },
            success: function(data) {
                $("#tabelrate").html(data);
            }
        });
    }
    
       
</script>


@endsection
