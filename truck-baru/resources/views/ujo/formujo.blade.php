@extends('layouts.master')
@section('css')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('build/js/accounting.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

@section('title', 'Shipment')
<div id="myModal" class="modal bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="col-6">
<div class="card">
    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada kesalahan data, silahkan dicek kembali<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form role="form" class="parsley-examples" action="{{ route('ujo.store') }}"
            method="POST">
            @csrf          
            <div class="mb-3">
                <label for="example-select" class="form-label">SO ID</label>
                <input type="text" id="shipmentid" name="shipmentid" class="form-control"
                    value="{{ $shipment->shipmentid }}" readonly style="background: rgb(235, 234, 234)">
            </div>

            <div class="mb-3">
                <label for="example-select" class="form-label">Origin</label>
                <input type="text" id="origin" name="origin" class="form-control" value="{{ $shipment->origin }}"
                    readonly style="background: rgb(235, 234, 234)">
            </div>

            <div class="mb-3">
                <label for="example-select" class="form-label">Destination</label>
                <input type="text" id="destination" name="destination" class="form-control"
                    value="{{ $shipment->destination }}" readonly style="background: rgb(235, 234, 234)">
            </div>
            <div class="mb-3">
                <label for="example-select" class="form-label">Type Truck</label>
                <input type="hidden" id="typetruckid" name="typetruckid" class="form-control"
                    value="{{ $shipment->typetruckid }}" readonly style="background: rgb(235, 234, 234)">
                <input type="text" id="namatypetruck" name="namatypetruck" class="form-control"
                    value="{{ $shipment->gettypetruck->namatypetruck }}" readonly
                    style="background: rgb(235, 234, 234)">
            </div>
            <div class="mb-3">
                <label for="example-select" class="form-label">No.UJO</label>
                <input type="text" id="noujo" name="noujo" class="form-control" placeholder="autogenerate"
                value="" readonly>
              
            
            </div>
           @include('ujo.rateujo')

           
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('ujo.index') }}" class="btn btn-secondary">Close</a>
        </form>


    </div>
</div>
</div>
<script>
     $('.btn-action').click(function() {
            var url = $(this).data("url");
            $.ajax({
                url: url,
                type: 'GET',
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