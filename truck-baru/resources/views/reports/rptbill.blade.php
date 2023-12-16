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
@section('title', 'Reports Bill')



<div class="row">
    <div class="card">

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('report.bill') }}" method="POST" target="_blank">
                @csrf

                <table class="table table-responsive">
                    <tr>
                        <td>Periode Laporan (Tgl. Approve)</td>
                        <td>
                            <input type="date" name="tglmulai" id="inputTglmulai" value="" required="required"
                                title=""> s/d <input type="date" name="tglakhir" id="inputTglmulai"
                                value="" required="required" title="">
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-primary"
                                onclick="return confirm('Cetak Laporan Ini ?')">Cetak</button>

                    </tr>

                </table>
            </form>
        </div>

    </div>
</div>


<script>
    var input = document.getElementById("search");

    // Execute a function when the user presses a key on the keyboard
    input.addEventListener("keypress", function(event) {
        // If the user presses the "Enter" key on the keyboard
        if (event.key === "Enter") {
            var keyword = $('#search').val();
            var kriteria = $("#kriteria").val();
            $.ajax({

                url: "{{ route('bill.searchshipment') }}",
                method: "GET",
                data: {
                    kriteria: kriteria,
                    keyword: keyword
                },
                success: function(data) {
                    $('#datashipment').html(data);
                }
            });
            event.preventDefault();
        }
    });
</script>
@endsection
