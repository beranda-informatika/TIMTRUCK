@extends('layouts.master')
@section('css')
    <!-- Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('content')
@section('title', 'Shiping Shipment')
@foreach ($shipment as $key)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Approve Loading</h4>
                <p class="sub-header">
                    Form Approve Shiping
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
                <form role="form" class="parsley-examples" action="{{ route('shiping.update',$key->shipmentid ) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="statustrans" name="statustrans" class="form-control" value="Loading">
                    <div class="row">
                        <div class="col-lg-6">


                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">No. ID * (otomatis)</label>
                                <input type="text" id="shipmentid" name="shipmentid" class="form-control" value="{{ $key->shipmentid }}"
                                    readonly style="background: rgb(235, 234, 234)">
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Origin - Destination</label>
                                <input type="text" id="origin" name="origin" class="form-control" value="{{ $key->origin }} - {{ $key->destination }}"
                                    readonly style="background: rgb(235, 234, 234)">

                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Customer</label>
                                <input type="text" id="kdcustomer" name="kdcustomer" class="form-control"
                                    value="{{ $key->kdcustomer }}" readonly style="background: rgb(235, 234, 234)">
                                    <div id="namacustomer">Customer </div>
                            </div>

                            <div class="mb-3">
                                <label for="example-select" class="form-label">Sales</label>
                                <input type="text" id="kdsales" name="kdsales" class="form-control" value="{{ $key->kdsales }}"
                                    readonly style="background: rgb(235, 234, 234)">
                                    <div id="namasales">Sales </div>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Project</label>
                                <input type="text" id="kdproject" name="kdproject" class="form-control" value="{{ $key->kdproject }}"
                                    readonly style="background: rgb(235, 234, 234)">
                                    <div id="namaproject">Project </div>
                            </div>

                        </div> <!-- end col -->

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Kategori</label>
                                <select class="form-select" id="kdkategori" name="kdkategori" required style="background: rgb(235, 234, 234)">
                                    <option value="">Pilih Kategori</option>
                                    <option value="{{ $key->kdkategori }}" selected>{{ $key->getkategori->namakategori }}</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Unit</label>
                                <select class="form-select" id="kdunit" name="kdunit" required style="background: rgb(235, 234, 234)" readonly>
                                    <option value="{{ $key->kdunit }}">{{ $key->getunit->plat }}</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Driver</label>
                                <select class="form-select" id="kddriver" name="kddriver" required style="background: rgb(235, 234, 234)" readonly>
                                    <option value="{{ $key->kddriver }}">{{ $key->getdriver->namadriver }}</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="example-textarea" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="5" required style="background: rgb(235, 234, 234)" readonly>{{ $key->keterangan }}</textarea>
                            </div>

                        </div> <!-- end col -->
                    </div>
                   <div class="row">
                    <div class="col-lg-6">

                        <div class="mb-3">
                            <label for="example-select" class="form-label">Tgl.Loading</label>
                            <input type="date" id="tglapprove" name="tglapprove" class="form-control"
                                value="">

                        </div>
                        <button type="submit" class="btn btn-success waves-effect waves-light me-1">
                            <i class="fa fa-check"></i> Approve Loading
                        </button>

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





</script>


@endsection
