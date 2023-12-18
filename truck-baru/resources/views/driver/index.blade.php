@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@section('title', 'Driver')
@include('layouts.tabel')

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <a href="{{ route('driver.index') }}" class="btn btn-primary mb-3">Refresh Driver</a>
                    <a href="{{ route('driver.create') }}" class="btn btn-primary mb-3">Add Driver</a>

                    <table id="example"
                    class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
                    cellspacing="0" style="border-collapse: collapse;  width: 100%;">
                        <thead>
                            <tr>

                                <th scope="col">Code Driver</th>
                                <th scope="col">Name Driver</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Bank Account</th>
                                <th scope="col">Number Account</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($driver as $key)
                                <tr>

                                    <td scope="col">{{ $key->kddriver }}</td>
                                    <td scope="col">{{ $key->namadriver }}</td>
                                    <td scope="col">{{ $key->nohp }}</td>
                                    <td scope="col">{{ $key->bank }}</td>
                                    <td scope="col">{{ $key->norekening }}</td>

                                    <td scope="col">

                                        <form action="{{ route('driver.destroy', $key->kddriver) }}" method="POST">
                                            <a href="{{ route('driver.edit', $key->kddriver) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure to delete?');"
                                                class="btn btn-sm btn-danger">Delete</button>
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

@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ URL::asset('build/js/pages/datatable-pages.init.js') }}"></script>    
    <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>
@endsection