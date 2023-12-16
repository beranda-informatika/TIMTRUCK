<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Ada kesalahan input data! <br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="row">
                        <div class="col-lg-6">


                            <div class="mb-0">
                                <label for="simpleinput" class="form-label">Route ID</label>
                                <input type="text" id="routeid" name="routeid" class="form-control"
                                    value="{{ $rute->routeid }}" required>

                            </div>
                            <div class="mb-0">
                                <label for="simpleinput" class="form-label">Route</label>
                                <input type="text" id="route" name="route" class="form-control"
                                    value="{{ $rute->route }}" required>
                            </div>
                            <div class="mb-0">
                                <label for="example-select" class="form-label">Kategori</label>
                                <select class="form-select" id="kdkategori" name="kdkategori" required>
                                    <option value="{{ $rute->kdkategori }}">{{ $rute->getkategori->namakategori }}</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="example-select" class="form-label">Project</label>
                                <select class="form-select" id="kdproject" name="kdproject" required>
                                    <option value="{{ $rute->kdproject }}">{{ $rute->getproject->namaproject }}</option>

                                </select>
                            </div>







                        </div> <!-- end col -->

                        <div class="col-lg-6">


                            <div class="mb-0">
                                <label for="example-select" class="form-label">Type Truck</label>
                                <select class="form-select" id="typetruckid" name="typetruckid" required>
                                    <option value="{{ $rute->typetruckid }}">{{ $rute->gettypetruck->namatypetruck }}</option>
                                </select>
                            </div>
                            <div class="mb-0">
                                <label for="example-textarea" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="5" required>{{ $rute->keterangan }}</textarea>
                            </div>

                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table" style="text-align: left; font-size: 12px">
                                <thead>

                                    <tr class="table-danger">
                                        <th scope="col">Rate Id</th>
                                        <th scope="col">Nama Rate</th>
                                        <th scope="col">Nominal</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">pph (%)</th>
                                        <th scope="col">Amount PPh</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <form>
                                        <?php $i = 0;
                                        $total = 0; ?>
                                        @foreach ($rute->getdetailrute as $data)
                                            <tr>
                                                <td width="15%">
                                                    <div id="kode" style="display:none"><?php echo $i; ?></div>
                                                    {{ $data->routeid }}
                                                </td>
                                                <td width="20%">
                                                    {{ $data->getrate->namarate }}
                                                </td>
                                                <td width="10%" style="text-align: right;">
                                                        {{ number_format($data->nominal,0) }}
                                                </td>

                                                <td width="5%" style="text-align: right;">
                                                        {{ $data->qty }}
                                                </td>
                                                <td width="10%" style="text-align: right;">
                                                    {{ number_format($data->jumlah,0) }}
                                                </td>
                                                <td width="5%" style="text-align: right;">
                                                    {{ $data->pph }}

                                                </td>
                                                <td width="5%" style="text-align: right;">

                                                        {{ number_format($data->pajak,0) }}

                                                </td>

                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </form>
                <!-- end row-->

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

