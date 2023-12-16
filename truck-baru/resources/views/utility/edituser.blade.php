@extends('layouts.master')

@section('title') Maintenance @endsection

@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<!-- start page title -->
@component('components.breadcrumb')
@slot('li_1') User @endslot
@slot('title') User Edit @endslot
@endcomponent
@include('sweetalert::alert')
<div class="row align-items-center">
    <div class="col-md-6">

    </div>

    <div class="col-md-6">
        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
            <div>
                <ul class="nav nav-pills">


                </ul>
            </div>
            <div>

            </div>

            <!-- <div class="dropdown">
                <a class="btn btn-link text-muted py-1 font-size-16 shadow-none dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-dots-horizontal-rounded"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Edit</a></li>
                    <li><a class="dropdown-item" href="#">Hapus</a></li>
                </ul>
            </div> -->
        </div>

    </div>
</div>
<!-- end row -->

<div class="table-responsive mb-4" id="tablecontent">
    <form action="{{ route('utility.updateuser',$users->id) }}" method="post">
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
                <label for=""><strong>Nama Lengkap</strong></label>
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap"
                    value="{{ $users->name }}">
            </div>
            <div class="form-group">
                <label for=""><strong>Email</strong></label>
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $users->email }}">
            </div>
            <div class="form-group">
                <label for=""><strong>Level User</strong></label>
                <select class="form-select" name="role" id="role">

                    <option value="{{ $users->roles_id }}" selected>{{ $users->role->role_name }}</option>
                    <option value=""> -- select --</option>
                    @foreach ($role as $itemrole)
                    <option value="{{ $itemrole->id }}">{{ $itemrole->role_name }}</option>
                    @endforeach
                </select>
            </div>
            
        </div>
        <br>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
    </form>
    <!-- end table -->
</div>
<!-- end table responsive -->
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