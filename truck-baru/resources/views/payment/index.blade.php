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
@section('title', 'Shipments Shiping')
<div id="myModal" class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog"
    aria-labelledby="scrollableModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollableModalTitle">Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="row">

    <div class="col-12">



        <div class="card">

            <div class="card-body">
                <a href="{{ route('approve.index') }}" class="btn btn-primary mb-3">Refresh</a>

                <div class="responsive-table-plugin">
                    <div class="table-rep-plugin">
                        <div class="table-responsive" data-pattern="priority-columns" style="overflow-x:scroll;">
                            <table id="datatable" class="table table-striped nowrap">

                                <thead>
                                    <tr>

                                        <th scope="col">No.ID</th>
                                        <th scope="col">Job Order</th>
                                        <th scope="col">Route</th>
                                        <th scope="col">Project</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Sales</th>
                                        <th scope="col">Driver</th>
                                        <th scope="col">Unit</th>

                                        <th scope="col">Tgl.Quotation</th>
                                        <th scope="col">Status</th>

                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($shipment as $key)
                                        <tr>
                                            <td scope="col">{{ $key->shipmentid }}</td>
                                            <td scope="col" style="text-align: center">


                                                <a href="{{ URL::to('/approve/resi/' . $key->shipmentid) }}"
                                                    class="btn btn-sm btn-success"><i class="fa fa-print"
                                                        aria-hidden="false"> Job Order </i></button>

                                            </td>
                                            <td scope="col">{{ $key->getrute->route }}</td>
                                            <td scope="col">{{ $key->getrute->getproject->namaproject }}</td>
                                            <td scope="col">{{ $key->getcustomer->namacustomer }}</td>
                                            <td scope="col">{{ $key->getsales->namasales }}</td>
                                            <td scope="col">{{ $key->getdriver->namadriver }}</td>
                                            <td scope="col">{{ $key->getunit->plat }}</td>

                                            <td scope="col">{{ $key->tglquotation }}</td>

                                            <td scope="col">

                                                @include('statusshipment.statusshipment')

                                            </td>


                                            <td scope="col">


                                                <form action="{{ route('shipment.destroy', $key->shipmentid) }}"
                                                    method="POST">
                                                    <a href="{{ route('shipment.edit', $key->shipmentid) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>

                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Hapus Data ini?');"
                                                        class="btn btn-sm btn-danger">Del</button>
                                                </form>
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
<script>
    $('.btn-action').click(function() {
        var url = $(this).data("url");

        $.ajax({
            url: url,
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
@endsection
