@extends('layouts.master')
@section('css')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('content')
@section('title', 'Shipment')

@foreach ($shipment as $item )

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Sales Order</h4>
                <p class="sub-header">
                    Form Edit Shipment Sales Order
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
                <form role="form" class="parsley-examples" action="{{ route('shipment.update', $item->shipmentid ) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6">


                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">No. Order * (otomatis)</label>
                                <input type="text" id="shipmentid" name="shipmentid" class="form-control"
                                    value="{{ $item->shipmentid }}" readonly style="background: rgb(235, 234, 234)">
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Quotation</label>

                                <input type="text" id="quotationid" name="quotationid" class="form-control"
                                value="{{ $item->quotationid }}" readonly style="background: rgb(235, 234, 234)">                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Origin</label>
                                <input type="text" id="origin" name="origin" class="form-control"
                                    value="{{ $item->origin }}" readonly style="background: rgb(235, 234, 234)">
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Destination</label>
                                <input type="text" id="destination" name="destination" class="form-control"
                                    value="{{ $item->destination }}" readonly style="background: rgb(235, 234, 234)">
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Type Truck</label>
                                <select class="form-select" id="typetruckid" name="typetruckid" required>
                                    <option value="{{ $item->typetruckid }}">{{ $item->gettypetruck->namatypetruck }}

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Customer</label>
                                <input type="text" id="kdcustomer" name="kdcustomer" class="form-control"
                                    value="{{ $item->kdcustomer }}" readonly style="background: rgb(235, 234, 234)">
                                <div id="namacustomer">{{ $item->getcustomer->namacustomer }} </div>
                            </div>


                            <div class="mb-3">
                                <label for="example-select" class="form-label">Kategori</label>
                                <input type="text" id="kdkategori" name="kdkategori" class="form-control"
                                    value="{{ $item->kdkategori }}" readonly style="background: rgb(235, 234, 234)">
                                <div id="namakategori">{{ $item->getkategori->namakategori}} </div>
                            </div>
                            <div class="mb-3">
                                <label for="example-textarea" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="description" name="description" rows="5" required>{{ $item->description }}</textarea>
                            </div>
                            <div class="mb-3">

                                <input type="hidden" id="mrc" name="mrc" class="form-control"
                                value="{{ $item->mrc }}" readonly style="background: rgb(235, 234, 234)">

                            </div>
                            <div class="mb-3">

                                <input type="hidden" id="ujo" name="ujo" class="form-control"
                                value="{{ $item->ujo }}" readonly style="background: rgb(235, 234, 234)">

                            </div>

                        </div> <!-- end col -->

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Sales</label>
                                <input type="text" id="kdsales" name="kdsales" class="form-control" value="{{ $item->kdsales }}"
                                    readonly style="background: rgb(235, 234, 234)">
                                <div id="namasales">{{ $item->getsales->namasales}} </div>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Project</label>
                                <select class="form-select" id="kdproject" name="kdproject" required>
                                    <option value="{{ $item->kdproject }}">{{ $item->getproject->namaproject }}
                                    <option value="">Pilih Project</option>
                                    @foreach ($project as $itemproject)
                                        <option value="{{ $itemproject->kdproject }}">{{ $itemproject->namaproject }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Unit</label>
                                <select class="form-select" id="kdunit" name="kdunit" required>
                                    <option value="{{ $item->kdunit }}">{{ $item->getunit->kdunit }} - {{ $item->getunit->plat }} - {{ $item->getunit->merk }} - {{ $item->getunit->typeunit }}

                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="example-select" class="form-label">Driver</label>
                                <select class="form-select" id="kddriver" name="kddriver" required>
                                    <option value="{{ $item->kddriver }}">{{ $item->getdriver->namadriver }}

                                </select>
                            </div>

                            <br>


                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Update
                                </button>
                                <a href="{{ route('shipment.index') }}"
                                    class="btn btn-secondary waves-effect">Cancel</a>
                            </div>

                        </div> <!-- end col -->
                    </div>


                </form>
                <!-- end row-->

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
@endforeach
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $("#kdunit").select2({
        placeholder: 'Pilih Unit',
        ajax: {
            url: "{{ route('unit.getunit') }}",
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
    $("#typetruckid").select2({
        placeholder: 'Pilih Unit',
        ajax: {
            url: "{{ route('typetruck.gettypetruck') }}",
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
    $("#kddriver").select2({
        placeholder: 'Pilih Driver',
        ajax: {
            url: "{{ route('driver.getdriver') }}",
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
