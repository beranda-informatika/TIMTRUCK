@extends('layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1>GANTI PASSWORD</h1>

                    </div>
                </div>
            </div>
        </section>


        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-center">Form ubah password</h3>
                            </div>
                            <form action="{{ route('utility.userpasswordupdate') }}" method="post">
                                @csrf
                                <div class="card-body">
                                    @if (session('errors'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            ada kesalahan:
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for=""><strong>Email</strong></label>
                                        <input type="text" name="email" class="form-control" placeholder="Email"
                                            value="{{ Auth::user()->email }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for=""><strong>Password</strong></label>
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for=""><strong>Konfirmasi Password</strong></label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Password">
                                    </div>


                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-block">Ubah</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
        </section>
    </div>

            @endsection
