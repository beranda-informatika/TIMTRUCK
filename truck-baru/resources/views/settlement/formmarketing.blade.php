<form role="form" class="parsley-examples" action="{{ route('shipment.store') }}" method="POST">
    @csrf
    <input type="text" id="kdcustomer" name="kdcustomer" class="form-control" value="{{ $kdcustomer }}" readonly
        style="background: rgb(235, 234, 234)">
    <div class="mb-3">
        <label for="example-select" class="form-label">Quotation ID</label>
        <input type="text" id="groupquotationid" name="groupquotationid" class="form-control"
            value="{{ $quotation->groupquotationid }}" readonly style="background: rgb(235, 234, 234)">

    </div>
    <div class="mb-3">
        <label for="example-select" class="form-label">Note</label><br>
        {!! $quotation->getgroupquotation->description !!}

    </div>
    <div class="mb-3">
        <label for="example-select" class="form-label">Category</label>
        <input type="text" id="kdkategori" name="kdkategori" class="form-control"
            value="{{ $quotation->getgroupquotation->kdkategori }}" readonly
            style="background: rgb(235, 234, 234)">
            <input type="text" id="namakategori" name="namakategori" class="form-control"
            value="{{ $quotation->getgroupquotation->getkategori->namakategori }}" readonly
            style="background: rgb(235, 234, 234)">
    </div>
    <div class="mb-3">
        <label for="example-select" class="form-label">Route ID</label>
        <input type="text" id="routeid" name="routeid" class="form-control" value="{{ $quotation->id }}" readonly
            style="background: rgb(235, 234, 234)">
    </div>

    <div class="mb-3">
        <label for="example-select" class="form-label">Origin</label>
        <input type="text" id="origin" name="origin" class="form-control" value="{{ $quotation->origin }}"
            readonly style="background: rgb(235, 234, 234)">
    </div>

    <div class="mb-3">
        <label for="example-select" class="form-label">Destination</label>
        <input type="text" id="destination" name="destination" class="form-control"
            value="{{ $quotation->destination }}" readonly style="background: rgb(235, 234, 234)">
    </div>
    <div class="mb-3">
        <label for="example-select" class="form-label">Type Route</label>
        <input type="text" id="typeroute" name="typeroute" class="form-control" value="{{ $quotation->typeroute }}" readonly
            style="background: rgb(235, 234, 234)">
    </div>
    <div class="mb-3">
        <label for="example-select" class="form-label">MRC</label><br>
        <div style="background: rgb(235, 234, 234)">{{ number_format($quotation->mrc) }}</div>
        <input type="hidden" id="mrc" name="mrc" class="form-control" value="{{ $quotation->mrc }}" readonly
            style="background: rgb(235, 234, 234)">

    </div>
    <div class="mb-3">
        <label for="example-select" class="form-label">UJO</label><br>
        <div style="background: rgb(235, 234, 234)">{{ number_format($quotation->ujo) }}</div>
        <input type="hidden" id="ujo" name="ujo" class="form-control" value="{{ $quotation->ujo }}" readonly
            style="background: rgb(235, 234, 234)">

    </div>
    <div class="mb-3">
        <label for="example-select" class="form-label">Type Truck</label>
        <input type="hidden" id="typetruckid" name="typetruckid" class="form-control"
            value="{{ $quotation->typetruckid }}" readonly style="background: rgb(235, 234, 234)">
        <input type="text" id="namatypetruck" name="namatypetruck" class="form-control"
            value="{{ $quotation->gettypetruck->namatypetruck }}" readonly style="background: rgb(235, 234, 234)">
    </div>
    <div class="mb-3">
        <label for="inputEmail3" class="col-4 col-form-label">Sales<span class="text-danger">*</span></label>

        <select name="kdsales" id="kdsales" required class="form-control"></select>
        <div data-url="{{ route('quotation.forminsales') }}" class="btn btn-sm btn-info  btn-action">+ New Sales if not
            available</div>

    </div>
    <div class="mb-3">
        <label for="example-textarea" class="form-label">Multi Drop</label>
        <select id="multidrop" name="multidrop" required>
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
        <div id="multidropform">
            <input type="number" id="qtydrop" name="qtydrop" value="" style="background: rgb(235, 234, 234)"
                placeholder="Point Drop">
            <input type="text" id="ratedrop" name="ratedrop" value=""
                style="background: rgb(235, 234, 234); text-align: right" placeholder="Rate Drop">
                <input type="text" id="locationdrop" name="locationdrop" value="" placeholder="Drop Location" class="form-control">
        </div>
    </div>
    <div class="mb-3">
        <label for="example-textarea" class="form-label">Multi Pickup</label>
        <select id="multipickup" name="multipickup" required>
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
        <div id="multipickupform">
            <input type="number" id="qtypickup" name="qtypickup" value="" style="background: rgb(235, 234, 234)"
                placeholder="Point Pickup">
            <input type="text" id="ratepickup" name="ratepickup" value=""
                style="background: rgb(235, 234, 234); text-align: right" placeholder="Rate Pickup">
                <input type="text" id="locationpickup" name="locationpickup" value="" placeholder="Pickup Location" class="form-control">
        </div>
    </div>
   
    <div class="mb-3">
        <label for="example-textarea" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="5" required>{{ $quotation->description }}</textarea>
    </div>




    <div class="mb-3">
        <label for="example-select" class="form-label">Project</label>
        <select class="form-select" id="kdproject" name="kdproject" required>

        </select>
        <div data-url="{{ route('quotation.forminproject') }}" class="btn btn-sm btn-info  btn-action">+ New Project
            if not
            available</div>
    </div>


    <br>


    <div class="mb-3">
        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan Order
        </button>
        <a href="{{ route('shipment.create') }}" class="btn btn-secondary waves-effect">Cancel</a>
    </div>
</form>
<div id="myModal" class="modal bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        $('#multidropform').hide();
        $('#multipickupform').hide();
    });
    $('#multidrop').change(function() {
        if ($(this).val() == 1) {
            $('#multidropform').show();
        } else {
            $('#multidropform').hide();
        }
    });
    $('#multipickup').change(function() {
        if ($(this).val() == 1) {
            $('#multipickupform').show();
        } else {
            $('#multipickupform').hide();
        }
    });



    $("#kdproject").select2({
        placeholder: 'select Project',
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
    $("#kdsales").select2({
        placeholder: 'select Sales',
        ajax: {
            url: "{{ route('sales.getsales') }}",
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
    $(document).on('submit', '#forminsales', function() {
        if (confirm("Save Sales?")) {
            $.ajax({
                url: "{{ route('quotation.salesstore') }}",
                type: "post",
                data: $(this)
                    .serialize(), //mengirim data secara serialize -- seluruh data input dikirim untuk diproses
                dataType: 'json', //respon yang diminta dalam format JSON
                success: function(response) {
                    if (response.status == 1) // return trmahasiswa dari hasil proses
                    {
                        alert('Data berhasil disimpan');
                        $('#myModal').modal('hide');
                    } else {
                        alert('Data gagal disimpan');
                        $('#myModal').modal('hide');

                    }
                }
            });
        };
        return false;
    });
    $(document).on('submit', '#forminproject', function() {
        if (confirm("Save Project?")) {
            $.ajax({
                url: "{{ route('quotation.projectstore') }}",
                type: "post",
                data: $(this)
                    .serialize(), //mengirim data secara serialize -- seluruh data input dikirim untuk diproses
                dataType: 'json', //respon yang diminta dalam format JSON
                success: function(response) {
                    if (response.status == 1) // return trmahasiswa dari hasil proses
                    {
                        alert('Data berhasil disimpan');
                        $('#myModal').modal('hide');
                    } else {
                        alert('Data gagal disimpan');
                        $('#myModal').modal('hide');

                    }
                }
            });
        };
        return false;
    });
    $('.btn-action').click(function() {
        var url = $(this).data("url");
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            success: function(res) {

                // get the ajax response data
                var data = res;

                // update modal content here
                // you may want to format data or
                // update other modal elements here too
                $('.modal-body').html(data);

                // show modal
                $('#myModal').modal('show');

            },
            error: function(request, status, error) {
                console.log("ajax call went wrong:" + request.responseText);
            }
        });
    });
</script>
