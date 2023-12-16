@extends('layouts.master')

@section('content')
@section('title', '')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <a href="{{ route('rate.index') }}" class="btn btn-primary mb-3">Refresh rate</a>
                    <a href="{{ route('rate.create') }}" class="btn btn-primary mb-3">Tambah rate</a>

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>

                                <th scope="col">Kode rate</th>
                                <th scope="col">Nama rate</th>
                                <th scope="col">Akun</th>
                                <th scope="col">Pajak</th>
                                <th scope="col">% Pajak</th>
                                <th scope="col">Akun Default</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($rate as $key)
                                <tr>

                                    <td scope="col">{{ $key->rateid }}</td>
                                    <td scope="col">{{ $key->namarate }}</td>
                                    <td scope="col">{{ $key->getakun->namaakun }}</td>
                                    <td scope="col">{{ $key->f_pajak }}</td>
                                    <td scope="col">{{ $key->persenpajak }}</td>
                                    <td scope="col">{{ $key->f_default }}</td>

                                    <td scope="col">

                                        <form action="{{ route('rate.destroy', $key->rateid) }}" method="POST">
                                            <a href="{{ route('rate.edit', $key->rateid) }}"
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
