<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Quotation</h4>
                <p class="sub-header">
                    Shipment Quotation
                </p>

                <div class="row">
                    <div class="col-lg-6">


                        <div class="mb-3">
                            <label for="simpleinput" class="form-label">No. ID * (otomatis)</label>
                            <input type="text" id="shipmentid" name="shipmentid" class="form-control"
                                value="{{ $shipment->shipmentid }}}" readonly style="background: rgb(235, 234, 234)">
                        </div>
                        <div class="mb-3">
                            <label for="example-select" class="form-label">No Order</label>
                            <select class="form-select" id="orderid" name="orderid" required>
                                <option value="{{ $shipment->orderid }}">{{ $shipment->orderid }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="example-select" class="form-label">Customer</label>
                            <input type="text" id="kdcustomer" name="kdcustomer" class="form-control"
                                value="{{ $shipment->getcustomer->namacustomer }}" readonly style="background: rgb(235, 234, 234)">
                            
                        </div>

                        <div class="mb-3">
                            <label for="example-select" class="form-label">Sales</label>
                            <input type="text" id="kdsales" name="kdsales" class="form-control"
                                value="{{ $shipment->getsales->namasales }}" readonly style="background: rgb(235, 234, 234)">
                           
                        </div>
                        <div class="mb-3">
                            <label for="example-select" class="form-label">Project</label>
                            <input type="text" id="kdproject" name="kdproject" class="form-control"
                                value="{{ $shipment->getrute->getproject->namaproject }}" readonly style="background: rgb(235, 234, 234)">
                            
                        </div>

                    </div> <!-- end col -->

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="example-select" class="form-label">Kategori</label>
                            <select class="form-select" id="kdkategori" name="kdkategori" required>
                                <option value="{{ $shipment->getrute->getkategori->namakategori }}">{{ $shipment->getrute->getkategori->namakategori }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="example-select" class="form-label">Unit</label>
                            <select class="form-select" id="kdunit" name="kdunit" required>
                                <option value="{{ $shipment->kdunit }}">{{ $shipment->kdunit }}</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="example-select" class="form-label">Driver</label>
                            <select class="form-select" id="kddriver" name="kddriver" required>
                                <option value="{{ $shipment->kddriver }}">{{ $shipment->getdriver->namadriver }}</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="example-textarea" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="5" required>{{ $shipment->keterangan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="example-select" class="form-label">Rute</label>
                            <select class="form-select" id="routeid" name="routeid" required>
                                <option value="{{ $shipment->routeid }}">{{ $shipment->getrute->route }}</option>

                            </select>
                        </div>
                    </div> <!-- end col -->
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered mb-0" style="text-align: left; font-size: 12px">
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
                                    @foreach ($shipment->getdetailshipment as $data)
                                        <tr>
                                            <td width="3%">
                                                <input type="hidden" name="rateid[]" id="rateid{{ $i }}"
                                                    value="{{ $data->rateid }}" readonly
                                                    style="text-align: left; width: 50px; background:rgb(239, 237, 237) ">
                                                {{ $data->rateid }}
                                                <div id="kode" style="display:none"><?php echo $i; ?></div>
                                            </td>
                                            <td width="15%">
                                                <input type="hidden" name="namarate[]"
                                                    id="namarate{{ $i }}"
                                                    value="{{ $data->getrate->namarate }}"
                                                    style="text-align: left; width: 100px; background:rgb(239, 237, 237)"
                                                    require readonly>
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

                <!-- end row-->

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
