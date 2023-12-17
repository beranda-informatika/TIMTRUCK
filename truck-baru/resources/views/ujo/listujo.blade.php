@extends('layouts.master')
@section('style')
    <!-- Select 2 -->
    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
    <!-- Responsive Table css -->


@endsection

@section('content')
@section('title', 'UJO')
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
                <a href="{{ route('ujo.listujo') }}" class="btn btn-primary mb-3">Refresh </a>
                <div class="responsive-table-plugin">
                    <div class="table-rep-plugin ">
                        <div class="table-responsive" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped nowrap">

                                <thead>
                                    <tr>

                                        <th scope="col">No.UJO</th>
                                        <th scope="col">No. SO</th>
                                        <th scope="col">Date Ujo</th>
                                        <th scope="col">Nominal UJO</th>
                                        <th scope="col">Paid off</th>
                                        <th scope="col">Status UJO</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($ujo as $key)
                                        <tr>
                                            <td scope="col">{{ $key->noujo }}</td>
                                            <td scope="col"><a href="{{ route('shipment.detail',$key->shipmentid)}}" >{{ $key->shipmentid }}</a></td>
                                            <td scope="col">{{ $key->tglujo }}</td>
                                            <td scope="col">{{ $key->nominalujo }}</td>
                                            <td scope="col">{{ $key->terbayar }}</td>
                                            <td scope="col">{{ $key->statusujo }}</td>
                                            <td scope="col">
                                                <form action="{{ route('ujo.destroy', $key->noujo) }}"
                                                    method="POST">
                                                    <a href="{{ route('payout.listinvoice', $key->noujo) }}"
                                                        class="btn btn-sm btn-warning">LIST REQUEST</a>
                                                    @if($key->f_lunas == 0)

                                                    <a href="{{ route('payout.forminvoice', $key->noujo) }}"
                                                        class="btn btn-sm btn-pink">REQUEST PAYMENT</a>
                                                    @endif

                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Delete this data?');"
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
