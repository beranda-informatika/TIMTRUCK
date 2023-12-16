@extends('layouts.master')
@section('style')
    <!-- Select 2 -->
    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
    <!-- Responsive Table css -->
    <link href="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Responsive Table js -->
    <script src="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
@endsection

@section('content')
@section('title', 'Shipments Bill')

<div class="row">

    <div class="col-12">



        <div class="card">

            <div class="card-body">
                <a href="{{ route('bill.index') }}" class="btn btn-primary mb-3">Refresh</a>
                <div class="responsive-table-plugin">
                    <div class="table-rep-plugin">
                        <div class="table-responsive" data-pattern="priority-columns" style="overflow-x:scroll;">
                            <table id="datatable" class="table table-striped nowrap">

                                <thead>
                                    <tr>

                                        <th scope="col">No.ID</th>
                                        <th scope="col">Route</th>
                                        <th scope="col">Project</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Sales</th>
                                        <th scope="col">Driver</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Invoice</th>
                                        <th scope="col">Tgl.Approve</th>
                                        <th scope="col">Status</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($shipment as $key)
                                        <tr>
                                            <td scope="col">{{ $key->shipmentid }}</td>
                                            <td scope="col">{{ $key->getrute->route }}</td>
                                            <td scope="col">{{ $key->getrute->getproject->namaproject }}</td>
                                            <td scope="col">{{ $key->getcustomer->namacustomer }}</td>
                                            <td scope="col">{{ $key->getsales->namasales }}</td>
                                            <td scope="col">{{ $key->getdriver->namadriver }}</td>
                                            <td scope="col">{{ $key->getunit->plat }}</td>
                                            <td scope="col">

                                                <a class="btn btn-action btn-sm btn-pink"
                                                    href="{{ URL::to('/bill/listbill/' . $key->shipmentid) }}"><i
                                                        class="fa fa-search-plus " aria-hidden="true"></i></a>
                                            </td>
                                            <td scope="col">{{ $key->tglapprove }}</td>
                                            <td scope="col">

                                                @include('statusshipment.statusshipment')

                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
