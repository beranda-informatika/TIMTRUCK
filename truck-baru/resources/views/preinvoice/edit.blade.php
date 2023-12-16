@extends('layouts.master')
@section('css')




    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">



@endsection
@section('title', 'Sales Order')
@section('content')
@include('sweetalert::alert')
<form method="POST" action="{{ route('preinvoice.update',$preinvoice->piid) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="mb-3">
                        <label for="example-select" class="form-label">Customer</label>
                        <input type="text" id="kdcustomer" name="kdcustomer" class="form-control"
                            value="{{ $preinvoice->kdcustomer }}" readonly style="background: rgb(235, 234, 234)">
                    </div>
                    <div class="mb-3">
                        <label for="example-select" class="form-label">Project</label>
                        <input type="text" id="project" name="project" class="form-control" value="{{ $preinvoice->project }}"
                            style="background: rgb(255, 252, 252); text-transform:uppercase" required>
                    </div>
                    <div class="mb-3">
                        <label for="example-select" class="form-label">Category</label>
                        <select class="form-select" id="kdkategori" name="kdkategori" required>
                            <option value="{{ $preinvoice->kdkategori }}">{{ $preinvoice->getkategori->namakategori }}</option>
                            <option value="">select category</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->kdkategori }}">{{ $item->namakategori }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive">
                        <h5>Select Shipment</h5>
                        <table id="example"
                            class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
                            cellspacing="0" style="border-collapse: collapse;  width: 100%;">

                            <thead>
                                <tr>
                                    <th>Checked</th>

                                    <th scope="col">shipment ID</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Quotation ID</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Tgl Request</th>
                                    <th scope="col">Origin</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Type Route</th>
                                    <th scope="col">MRC</th>
                                    <th scope="col">UJO</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Sales</th>
                                    <th scope="col">Type Truck</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Driver</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp

                                @foreach ($shipment as $key)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="listshipment[]" value="{{ $key->shipmentid }}" checked>
                                        </td>

                                        <td scope="col">{{ $key->shipmentid }}</td>
                                        <td scope="col">{{ $key->getshipment->getcustomer->namacustomer }}</td>
                                        <td scope="col"><span class="badge bg-danger">
                                                {{ $key->getshipment->f_status }}
                                            </span>

                                        </td>


                                        <td>{{ $key->getshipment->groupquotationid }}</td>
                                        <td scope="col">{{ $key->getshipment->kdkategori }}</td>
                                        <td scope="col">{{ $key->getshipment->tglorder }}</td>
                                        <td scope="col">{{ $key->getshipment->origin }}</td>
                                        <td scope="col">{{ $key->getshipment->destination }}</td>
                                        <td scope="col">{{ $key->getshipment->typeroute }}</td>
                                        <td scope="col" style="text-align: right">
                                            @if (Auth::user()->roles_id == 1 ||
                                                    Auth::user()->roles_id == 2 ||
                                                    Auth::user()->roles_id == 3 ||
                                                    Auth::user()->roles_id == 5)
                                                {{ number_format($key->getshipment->mrc) }}
                                            @endif
                                        </td>
                                        <td scope="col" style="text-align: right">
                                            @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2 || Auth::user()->roles_id == 5)
                                                {{ number_format($key->getshipment->ujo) }}
                                            @endif
                                        </td>
                                        <td scope="col">{{ $key->getshipment->description }}</td>


                                        <td scope="col">{{ $key->getshipment->getsales->namasales }}</td>


                                        <td scope="col">{{ $key->getshipment->gettypetruck->namatypetruck }}</td>
                                        <td scope="col">
                                            @if ($key->getshipment->kddriver != null)
                                                {{ $key->getshipment->getdriver->namadriver }}
                                            @endif
                                        </td>
                                        <td scope="col">
                                            @if ($key->getshipment->kdunit != null)
                                                {{ $key->getshipment->getunit->plat }}
                                            @endif
                                        </td>



                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="mb-3">
                        <br>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save
                        </button>
                        <a href="{{ route('preinvoice.index') }}" class="btn btn-secondary waves-effect">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'print'
            ]
        });

    } );
    </script>
@endsection
