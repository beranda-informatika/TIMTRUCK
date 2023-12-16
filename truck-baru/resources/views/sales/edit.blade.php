@extends('layouts.master')
@section('content')
@section('title', 'sales')

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
                            <h4 class="header-title">sales Form</h4>
                            <p class="text-muted font-14">
                                Form Edit Master sales
                            </p>

                            <form role="form" class="parsley-examples" action="{{ route('sales.update', $sales->kdsales)}}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Kode sales<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="kdsales" name="kdsales" placeholder="Kode sales" value="{{ $sales->kdsales }}"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Nama sales<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="namasales" name="namasales" placeholder="Nama sales" value="{{ $sales->namasales }}"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-8 offset-4">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                        <a href="{{ route('sales.index') }}"
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