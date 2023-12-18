@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>admin</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-body">
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
                                    <form action="{{ route('admin.store') }}" method="POST" role="form"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>id</label>
                                            <input type="text" class="form-control" id="id" name="id"
                                                placeholder="kode (otomatis)" value="{{ old('id') }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Name </label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="name" value="{{ old('name') }}" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>email </label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="email " value="{{ old('email') }}" required="">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Password </label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="password" value="{{ old('password') }}" required="">
                                        </div>                                 
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="{{ route('admin.index') }}">
                                            <div class="btn btn-primary">Back</div>
                                        </a>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    $('#kdkab').change(function() {
        $('#kdkec').html('');
        var id = $(this).val();
        var string="{{ asset('/wilayah/getkecamatan/') }}/"+id;      
        $.ajax({
            type: 'GET',
            url: string,
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                datax = JSON.stringify(data);
                datax = JSON.parse(datax);
                var i;
                var html = '';
                for (i = 0; i < datax.length; i++) {
                    html += "<option value='" + datax[i].idwil + "'>" + datax[i].nmwil +
                    "</option>";
                }
                $('#kdkec').html(html);
            }
        });
        return false;
    });
    $('#kdkec').change(function() {
        $('#kdkel').html('');
        var id = $(this).val();
        var string="{{ asset('/wilayah/getkelurahan/') }}/"+id;      
        $.ajax({
            type: 'GET',
            url: string,
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                datax = JSON.stringify(data);
                datax = JSON.parse(datax);
                var i;
                var html = '';
                for (i = 0; i < datax.length; i++) {
                    html += "<option value='" + datax[i].idwil + "'>" + datax[i].nmwil +
                    "</option>";
                }
                $('#kdkel').html(html);
            }
        });
        return false;
    });
    </script>
    @endsection