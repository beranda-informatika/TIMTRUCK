<form method="POST" action="{{ route('preinvoice.store') }}">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="mb-3">
                        <label for="example-select" class="form-label">Customer</label>
                        <input type="text" id="kdcustomer" name="kdcustomer" class="form-control"
                            value="{{ $kdcustomer }}" readonly style="background: rgb(235, 234, 234)">
                    </div>
                    <div class="mb-3">
                        <label for="example-select" class="form-label">Project</label>
                        <input type="text" id="project" name="project" class="form-control" value=""
                            style="background: rgb(255, 252, 252); text-transform:uppercase" required>
                    </div>
                    <div class="mb-3">
                        <label for="example-select" class="form-label">Category</label>
                        <select class="form-select" id="kdkategori" name="kdkategori" required>
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
                                    <th scope="col">Action</th>
                                    <th scope="col">Act</th>


                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp

                                @foreach ($shipment as $key)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="listshipment[]" value="{{ $key->shipmentid }}">
                                        </td>

                                        <td scope="col">{{ $key->shipmentid }}</td>
                                        <td scope="col">{{ $key->getcustomer->namacustomer }}</td>
                                        <td scope="col"><span class="badge bg-danger">
                                                {{ $key->f_status }}
                                            </span>

                                        </td>


                                        <td>{{ $key->groupquotationid }}</td>
                                        <td scope="col">{{ $key->kdkategori }}</td>
                                        <td scope="col">{{ $key->tglorder }}</td>
                                        <td scope="col">{{ $key->origin }}</td>
                                        <td scope="col">{{ $key->destination }}</td>
                                        <td scope="col">{{ $key->typeroute }}</td>
                                        <td scope="col" style="text-align: right">
                                            @if (Auth::user()->roles_id == 1 ||
                                                    Auth::user()->roles_id == 2 ||
                                                    Auth::user()->roles_id == 3 ||
                                                    Auth::user()->roles_id == 4)
                                                {{ number_format($key->mrc) }}
                                            @endif
                                        </td>
                                        <td scope="col" style="text-align: right">
                                            @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2 || Auth::user()->roles_id == 4)
                                                {{ number_format($key->ujo) }}
                                            @endif
                                        </td>
                                        <td scope="col">{{ $key->description }}</td>


                                        <td scope="col">{{ $key->getsales->namasales }}</td>


                                        <td scope="col">{{ $key->gettypetruck->namatypetruck }}</td>
                                        <td scope="col">
                                            @if ($key->kddriver != null)
                                                {{ $key->getdriver->namadriver }}
                                            @endif
                                        </td>
                                        <td scope="col">
                                            @if ($key->kdunit != null)
                                                {{ $key->getunit->plat }}
                                            @endif
                                        </td>
                                        <td scope="col">

                                            @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2 || Auth::user()->roles_id == 4)
                                                @if ($key->f_operational == 1)
                                                    <div id="kode" style="display: none">{{ $key->shipmentid }}
                                                    </div>
                                                    <a href="{{ route('settlement.inujo', $key->shipmentid) }}"
                                                        class="btn btn-sm btn-primary">SETTLEMENT UJO</a>
                                                    @if ($key->typeroute == 'load')
                                                        <a href="{{ route('settlement.inrevenue', $key->shipmentid) }}"
                                                            class="btn btn-sm btn-danger">SETTLEMENT MRC</a>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div id="kode" style="display: none">{{ $key->shipmentid }}</div>
                                            @if (Auth::user()->roles_id == 4 && $key->f_operational == 0)
                                                <div class="btn btn-sm btn-warning entry">Entry Unit & Driver</div>
                                            @endif
                                            @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2)
                                                <form action="{{ route('shipment.destroy', $key->shipmentid) }}"
                                                    method="POST">

                                                    <div class="btn btn-sm btn-warning entry">Entry Unit & Driver</div>

                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Hapus Data ini?');"
                                                        class="btn btn-sm btn-danger">Delete</button>
                                                </form>
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
