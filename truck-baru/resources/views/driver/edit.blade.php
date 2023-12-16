@extends('layouts.master')
@section('content')
@section('title', 'Driver')

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
                            <h4 class="header-title">driver Form</h4>
                            <p class="text-muted font-14">
                                Form Edit Master driver
                            </p>

                            <form role="form" class="parsley-examples" action="{{ route('driver.update', $driver->kddriver)}}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Kode driver<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="kddriver" name="kddriver" placeholder="Kode driver" value="{{ $driver->kddriver }}"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Nama Driver<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="namadriver" name="namadriver" placeholder="Nama Driver" value="{{ $driver->namadriver }}"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">No HP<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="nohp" name="nohp" placeholder="No HP" value="{{ $driver->nohp }}"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Bank<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <select class="form-control" id="bank" name="bank">
                                            <option value="{{ $driver->bank }}" selected>{{ $driver->bank }}</option>
                                            <option value="BCA">BCA</option>
                                            <option value="BNI">BNI</option>
                                            <option value="BRI">BRI</option>
                                            <option value="MANDIRI">MANDIRI</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Atas Nama Rekening<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="namarekening" name="namarekening" placeholder="an Rekening" value="{{ $driver->namarekening }}"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">No Rekening<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="norekening" name="norekening" placeholder="No Rekening" value="{{ $driver->norekening }}"/>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-8 offset-4">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                        <a href="{{ route('driver.index') }}"
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




@endsection
