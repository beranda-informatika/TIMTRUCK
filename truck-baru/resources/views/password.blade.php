@extends('layouts.master')

@section('title') User List @endsection

@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<!-- start page title -->
@component('components.breadcrumb')
@slot('li_1') Contacts @endslot
@slot('title') User List @endslot
@endcomponent
@include('sweetalert::alert')
<div class="row align-items-center">

<legend>Ubah Password</legend>

<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
        
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
	<form action="{{ route('utility.userpasswordupdate') }}" method="POST" role="form"  enctype="multipart/form-data">
			@csrf	
			<div class="form-group">
				<label class="control-label col-md-4">Email</label>				
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<input type="email" name="email" class="form-control" placeholder="email" id="email" required="" readonly value="{{ Auth::user()->email }}">				
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4">Password Baru</label>				
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<input type="password" name="password" class="form-control" placeholder="Password Baru" id="password" required="">				
				</div>
			</div>
			<div class="form-group">
                        <label for=""><strong>Konfirmasi Password</strong></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
                    </div>
			<div class="form-group">
				<div class="col-sm-8 col-sm-offset-4">
			<br>
					<button type="submit" class="btn btn-primary" id="btnsubmit" >Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
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