@extends('layouts.master')
@section('content')
@section('title', 'Unit')

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
                            <h4 class="header-title">Unit Form</h4>
                            <p class="text-muted font-14">
                                Form Input Master Unit
                            </p>

                            <form role="form" class="parsley-examples" action="{{ route('unit.store')}}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Kode Unit<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="kdunit" name="kdunit" placeholder="Kode Unit" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Plat<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="plat" name="plat" placeholder="Plat" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Merk<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="merk" name="merk" placeholder="Merk" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-4 col-form-label">Type Unit<span class="text-danger">*</span></label>
                                    <div class="col-7">
                                        <input type="text" required parsley-type="text" class="form-control" id="typeunit" name="typeunit" placeholder="Type Unit" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-8 offset-4">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                        <a href="{{ route('unit.index') }}"
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
    jQuery('#idcbu').change(function() {
    jQuery('#idregion').html('');
    var id = $(this).val();
    var string = "{{ asset('/lokasi/getregion/') }}/" + id;
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
            var html = '<option>Select</option>';
            for (i = 0; i < datax.length; i++) {
                html += "<option value='" + datax[i].id + "'>" + datax[i].namaregion +
                    "</option>";
            }
            $('#idregion').html(html);
        }
    });
    });
    jQuery('#idregion').change(function() {
    jQuery('#idsitename').html('');
    var id = $(this).val();
    var string = "{{ asset('/lokasi/getsitename/') }}/" + id;
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
            var html = '<option>Select</option>';
            for (i = 0; i < datax.length; i++) {
                html += "<option value='" + datax[i].id + "'>" + datax[i].namasitename +
                    "</option>";
            }
            $('#idsitename').html(html);
        }
    });
    });
</script>





@endsection