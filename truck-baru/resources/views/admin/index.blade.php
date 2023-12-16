@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <a href="{{ route('admin.index') }}">
                            <div id="viewData" class="btn btn-info">Daftar Admin</div>
                        </a>
                        <a href="{{ route('admin.create') }}">
                            <div id="viewData" class="btn btn-info">Tambah admin</div>
                        </a>
                        <br>
                        <br>

                        <table class="table  table-hover table-responsive" id='mydata'>
                            <thead>
                                <tr>
                                    <th>
                                        Kode
                                    </th>
                                    <th>
                                        Name 
                                    </th>
                                    <th>
                                        email 
                                    </th>
                                    

                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($admins as $key)
                                    <tr>
                                        <td><?php echo $key->id; ?></td>
                                        <td><?php echo $key->name; ?></td>
                                        <td><?php echo $key->email; ?></td>
                                        
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <br>
                    </div>

                </div>
            </div>
        </section>
    </div>
    <script>
        $(function() {
            $('#mydata').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        })
    </script>
@endsection
