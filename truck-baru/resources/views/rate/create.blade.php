@extends('layouts.master')
@section('css')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('content')
@section('title', 'rate')



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">rate Form</h4>
                            <p class="text-muted font-14">
                                Form Input Master rate
                            </p>

                            <form role="form" class="parsley-examples" action="{{ route('rate.store') }}"
                                method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Kode rate<span
                                            class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control"
                                            id="rateid" name="rateid" placeholder="Kode rate"
                                            value="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Nama rate<span
                                            class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control"
                                            id="namarate" name="namarate" placeholder="Nama rate"
                                            value="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Akun<span
                                            class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <select name="kdakun" id="kdakun" required class="form-control">
                                            <option value="">--Pilih Akun--</option>
                                            @foreach ($akun as $key)
                                                <option value="{{ $key->kdakun }}">{{ $key->namaakun }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label"> Kena Pajak<span
                                            class="text-danger">*</span></label>
                                    <div class="col-7">
                                       <select name="f_pajak" id="f_pajak" required class="form-control">
                                            <option value="">--Pilih Pajak--</option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label"> % Pajak<span
                                            class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control"
                                            id="persenpajak" name="persenpajak" placeholder="persenpajak"
                                            value="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label"> Default rate<span
                                            class="text-danger">*</span></label>
                                    <div class="col-7">
                                       <select name="f_default" id="f_default" required class="form-control">
                                            <option value="">--Pilih Default--</option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-8 offset-4">
                                        <button type="submit"
                                            class="btn btn-primary waves-effect waves-light">Save</button>
                                            <a href="{{ route('rate.index') }}"
                                            class="btn btn-secondary waves-effect">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end card -->

                </div> <!-- end col -->

            </div>
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
<!-- end row-->
<!-- end row -->

<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $("#kdproject").select2({
        placeholder: 'Pilih Project',
        ajax: {
            url: "{{ route('project.getproject') }}",
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
