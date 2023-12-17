@extends('layouts.master')
@section('css')
    <script src="{{ asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('build/js/accounting.js') }}"></script>


@endsection
@section('title', 'order')
@section('content')
    @include('sweetalert::alert')
    <h4>Sales Order</h4>
    <hr>
    <div class="row">
        <div class="col-2">

            @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2 || Auth::user()->roles_id == 4)
                @if ($shipment->f_operational == 1)
                    <div id="kode" style="display: none">{{ $shipment->shipmentid }}</div>
                    <a href="{{ route('shipment.inujo', $shipment->shipmentid) }}" class="btn btn-sm btn-primary">UJO</a><br>

                    <a href="{{ route('payout.listinvoice', $shipment->shipmentid) }}" class="btn btn-sm btn-success">LIST
                        PAYMENT UJO
                    </a><br>
                @endif
                @if ($shipment->f_status == 'Loading')
                    <a href="{{ route('shipment.listpod', $shipment->shipmentid) }}" class="btn btn-sm btn-info">DOC
                        POD</a><br>
                    <a href="{{ route('shipment.changeroute', $shipment->shipmentid) }}"
                        class="btn btn-sm btn-danger">Change Route</a><br>
                @endif
                @if ($shipment->f_status == 'Shiping')
                    <a href="{{ route('shipment.listpod', $shipment->shipmentid) }}" class="btn btn-sm btn-info">DOC
                        POD</a><br>
                @endif
            @endif
            <div id="kode" style="display: none">{{ $shipment->shipmentid }}</div>
            @if (Auth::user()->roles_id == 4 && $shipment->f_operational == 0)
                <div class="btn btn-sm btn-warning entry">Entry Unit & Driver</div>
            @endif
            @if (Auth::user()->roles_id == 4 && $shipment->f_status == 'Payout' && $shipment->f_operational == 1)
                <a href="{{ route('shiping.formloading', $shipment->shipmentid) }}" class="btn btn-sm btn-warning">Acc
                    Loading</a><br>
            @endif
            @if (Auth::user()->roles_id == 4 && $shipment->f_status == 'Loading' && $shipment->f_operational == 1)
                <a href="{{ route('shiping.formapprove', $shipment->shipmentid) }}" class="btn btn-sm btn-pink">Acc
                    Shiping</a><br>
            @endif
            @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2)
                <form action="{{ route('shipment.destroy', $shipment->shipmentid) }}" method="POST">

                    <div class="btn btn-sm btn-warning entry">Entry Unit & Driver</div><br>

                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus Data ini?');"
                        class="btn btn-sm btn-danger">Delete</button>
                </form>
            @endif

            @if (Auth::user()->roles_id == 3 && $shipment->f_status == 'New' && $shipment->f_operational == 0)
                <form action="{{ route('shipment.destroy', $shipment->shipmentid) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus Data ini?');"
                        class="btn btn-sm btn-danger">Delete</button>
                </form>
            @endif



        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="example-select" class="form-label">Status</label>
                <span class="badge bg-danger">
                    {{ $shipment->f_status }}
                </span>

            </div>
            <div class="mb-3">
                <label for="example-select" class="form-label">Customer</label>
                <input type="text" id="kdcustomer" name="kdcustomer" class="form-control"
                    value="{{ $shipment->kdcustomer }}" readonly style="background: rgb(235, 234, 234)">
            </div>
            <div class="mb-3">
                <label for="example-select" class="form-label">Quotation ID</label>
                <input type="text" id="groupquotationid" name="groupquotationid" class="form-control"
                    value="{{ $shipment->groupquotationid }}" readonly style="background: rgb(235, 234, 234)">

            </div>
            <div class="mb-3">
                <label for="example-select" class="form-label">Route ID</label>
                <input type="text" id="quotationid" name="quotationid" class="form-control"
                    value="{{ $shipment->quotationid }}" readonly style="background: rgb(235, 234, 234)">

            </div>
            {{-- <div class="mb-3">
                <label for="example-select" class="form-label">Note</label><br>
                {!! $shipment->getquotation->getgroupquotation->description !!}

            </div> --}}
            <div class="mb-3">
                <label for="example-select" class="form-label">Category</label>
                <input type="hidden" id="kdkategori" name="kdkategori" class="form-control"
                    value="{{ $shipment->getquotation->getgroupquotation->kdkategori }}" readonly
                    style="background: rgb(235, 234, 234)">
                <input type="text" id="namakategori" name="namakategori" class="form-control"
                    value="{{ $shipment->getquotation->getgroupquotation->getkategori->namakategori }}" readonly
                    style="background: rgb(235, 234, 234)">
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
                <label for="example-select" class="form-label">Type Route</label>
                <input type="text" id="typeroute" name="typeroute" class="form-control"
                    value="{{ $shipment->typeroute }}" readonly style="background: rgb(235, 234, 234)">
            </div>
            <div class="mb-3">
                <label for="example-select" class="form-label">MRC</label><br>
                @if (Auth::user()->roles_id == 1 ||
                        Auth::user()->roles_id == 2 ||
                        Auth::user()->roles_id == 3 ||
                        Auth::user()->roles_id == 4)
                    @if ($shipment->typeroute == 'load')
                        {{ number_format($shipment->unitmrc) }}
                    @else
                        {{ number_format($shipment->mrc) }}
                    @endif
                @endif

            </div>
            <div class="mb-3">
                <label for="example-select" class="form-label">UJO</label><br>
                @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2 || Auth::user()->roles_id == 4)
                    {{ number_format($shipment->ujo) }}
                @endif

            </div>
            <div class="mb-3">
                <label for="example-select" class="form-label">Type Truck</label>
                <input type="hidden" id="typetruckid" name="typetruckid" class="form-control"
                    value="{{ $shipment->typetruckid }}" readonly style="background: rgb(235, 234, 234)">
                <input type="text" id="namatypetruck" name="namatypetruck" class="form-control"
                    value="{{ $shipment->gettypetruck->namatypetruck }}" readonly style="background: rgb(235, 234, 234)">
            </div>
            <div class="mb-3">
                <label for="inputEmail3" class="col-4 col-form-label">Sales<span class="text-danger">*</span></label>
                {{ $shipment->getsales->namasales }}

            </div>
            <div class="mb-3">
                <label for="example-textarea" class="form-label">Multi Drop</label>

                @if ($shipment->multidrop=="1")
                Y<br>
                @foreach ($shipment->getmultidrop as $itemdrop )
                    {{ $itemdrop->location }} <br>

                @endforeach

                @endif

            </div>
            <div class="mb-3">
                <label for="example-textarea" class="form-label">Multi Pickup</label>
                @if ($shipment->multipickup=="1")
                Y<br>
                @foreach ($shipment->getmultipickup as $itempickup )
                    {{ $itempickup->location }} <br>

                @endforeach

                @endif

            </div>

            <div class="mb-3">
                <label for="example-textarea" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required>{{ $shipment->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="example-textarea" class="form-label">Unit </label>
                @if ($shipment->kdunit != null)
                    {{ $shipment->kdunit }} - {{ $shipment->getunit->plat }} - {{ $shipment->getunit->typeunit }}
                @endif

            </div>
            <div class="mb-3">
                <label for="example-textarea" class="form-label">Driver </label>
                @if ($shipment->kddriver != null)
                    {{ $shipment->kddriver }} - {{ $shipment->getdriver->namadriver }}
                @endif


            </div>




            <br>


            <div class="mb-3">

                <a href="{{ route('shipment.index') }}" class="btn btn-secondary waves-effect">Close</a>
            </div>
        </div>
        <div class="col-4">
            <div id="tabeldata"></div>
        </div>
    </div>

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
        var csrf = $('meta[name="csrf-token"]').attr('content');

        $(document).on('click', '.entry', function() {
            var id = $(this).siblings('#kode').text();
            $.ajax({
                type: "get",
                data: {
                    id: id,
                    _token: csrf
                },
                url: "{{ route('shipment.formoperational') }}",
                success: function(data) {
                    $("#tabeldata").html(data);
                }
            });
            return false;


        });
        $('.accshipment').click(function() {
            var id = $(this).siblings('#kode').text();
            var confirmText = "Acc Sales Order?";
            if (confirm(confirmText)) {
                $.ajax({
                    type: "post",
                    data: {
                        id: id,
                        _token: csrf
                    },
                    url: "",
                    success: function() {
                        location.reload();

                    },
                });
            }
            return false;
        });
        $('.accarrival').click(function() {
            var id = $(this).siblings('#kode').text();
            var confirmText = "Acc shipment?";
            if (confirm(confirmText)) {
                $.ajax({
                    type: "post",
                    data: {
                        id: id,
                        _token: csrf
                    },
                    url: "",
                    success: function() {
                        location.reload();

                    },
                });
            }
            return false;
        });
    </script>

@endsection
