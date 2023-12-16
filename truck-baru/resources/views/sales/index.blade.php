@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@section('title', 'sales')
@include('layouts.tabel')


    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <a href="{{ route('sales.index') }}" class="btn btn-primary mb-3">Refresh sales</a>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Tambah sales</a>

                    <table id="example"
                    class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
                    cellspacing="0" style="border-collapse: collapse;  width: 100%;">
                        <thead>
                            <tr>

                                <th scope="col">Kode sales</th>
                                <th scope="col">Nama sales</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($sales as $key)
                                <tr>

                                    <td scope="col">{{ $key->kdsales }}</td>
                                    <td scope="col">{{ $key->namasales }}</td>
                                    <td scope="col">

                                        <form action="{{ route('sales.destroy', $key->kdsales) }}" method="POST">
                                            <a href="{{ route('sales.edit', $key->kdsales) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus Data ini?');"
                                                class="btn btn-sm btn-danger">Hapus</button>
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