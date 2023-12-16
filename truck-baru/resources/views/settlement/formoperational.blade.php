
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


<div class="card col-4">
    <div class="card-body">


        <form role="form" class="parsley-examples" action="{{ route('shipment.update', $shipment->shipmentid) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="example-select" class="form-label">SO ID</label>
                <input type="text" id="shipmentid" name="shipmentid" class="form-control" value="{{ $shipment->shipmentid }}"
                    readonly style="background: rgb(235, 234, 234)">
            </div>
            
            <div class="mb-3">
                <label for="example-select" class="form-label">Origin</label>
                <input type="text" id="origin" name="origin" class="form-control" value="{{ $shipment->origin }}"
                    readonly style="background: rgb(235, 234, 234)">
            </div>

            <div class="mb-3">
                <label for="example-select" class="form-label">Destination</label>
                <input type="text" id="destination" name="destination" class="form-control"
                    value="{{ $shipment->destination }}" readonly style="background: rgb(235, 234, 234)">
            </div>
            <div class="mb-3">
                <label for="example-select" class="form-label">Type Truck</label>
                <input type="hidden" id="typetruckid" name="typetruckid" class="form-control"
                    value="{{ $shipment->typetruckid }}" readonly style="background: rgb(235, 234, 234)">
                <input type="text" id="namatypetruck" name="namatypetruck" class="form-control"
                    value="{{ $shipment->gettypetruck->namatypetruck }}" readonly
                    style="background: rgb(235, 234, 234)">
            </div>
            <div class="mb-3">
                <label for="example-select" class="form-label">Unit</label>
                <select class="form-select" id="kdunit" name="kdunit" required>

                </select>
            </div>

            <div class="mb-3">
                <label for="example-select" class="form-label">Driver</label>
                <select class="form-select" id="kddriver" name="kddriver" required>

                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('shipment.index')}}" class="btn btn-secondary" >Close</a>
        </form>

            
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#kdunit").select2({
            placeholder: 'select Unit',
            ajax: {
                url: "{{ route('unit.getunit') }}",
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
        $("#kddriver").select2({
            placeholder: 'select Driver',
            ajax: {
                url: "{{ route('driver.getdriver') }}",
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
    });
</script>
