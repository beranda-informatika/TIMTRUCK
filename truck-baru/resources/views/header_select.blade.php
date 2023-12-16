
<div class="row">
    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-h-100">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">

                    <div class="col-12">

                        <span class="text-muted mb-3 lh-1 d-block text-truncate"> CBU</span>
                        <h4 class="mb-3">

                        <select class="form-select" aria-label="Default select example" name="idcbu"
                                        id="idcbu">
                                        <option value="{{ Session::get('runidcbu') }}" selected>{{ Session::get('runnamacbu') }}</option>
                                        <option value="" >select</option>
                                        @foreach ($cbu as $itemcbu)
                                        <option value="{{ $itemcbu->id }}">{{ $itemcbu->namacbu }}</option>
                                        @endforeach
                                    </select>
                        </h4>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-h-100">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">REGION</span>
                        <h4 class="mb-3">
                        <select class="form-select" aria-label="Default select example" name="idregion"
                                        id="idregion">
                                        <option value="{{ Session::get('runidregion') }}" selected>{{ Session::get('runnamaregion') }}</option>
                                    </select>

                        </h4>
                    </div>
                </div>

            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col-->

    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-h-100">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">SITE NAME</span>

                        <h4 class="mb-3">

                        <select class="form-select" aria-label="Default select example" name="idsitename"
                                        id="idsitename">
                                        <option value="{{ Session::get('runidsitename') }}" selected>{{ Session::get('runnamasitename') }}</option>

                                    </select>
                        </h4>
        
                        
                    </div>

                </div>

            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row-->
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
    jQuery('#idsitename').change(function() {
    var id = $(this).val();
    var string = "{{ asset('/lokasi/setsitename/') }}/" + id;
    $.ajax({
        type: 'GET',
        url: string,
        data: {
            id: id
        },
        dataType: 'json',
        success: function(data) {
            $('#sitename').html('sukses');
          
            
        }
    });
    });
</script>
