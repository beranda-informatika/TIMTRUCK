<script src="{{ asset('/build/js/accounting.js') }}"></script>
<form action="{{ route('payment.store')}}" method="post">
    @csrf
    @foreach ($invoice as $item)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="panel-body">
                            <div class="clearfix">
                                <div class="float-start">
                                    <h3>Satria Piranti Perkasa</h3>
                                </div>
                                <div class="float-end">
                                    <h4>UJO # <br>
                                        <strong>{{ $item->noinvoice }}</strong>
                                    </h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="float-start mt-3">
                                        <p>
                                            <strong>UJO Date: </strong> {{ $item->tglinvoice }}<br>
                                            <strong>SO ID: </strong> {{ $item->shipmentid }} <br>
                                            <input type="hidden" name="shipmentid" id="shipmentid"
                                                value="{{ $item->shipmentid }}" required readonly>
                                            <strong>Driver : </strong> {{ $item->getshipment->getdriver->namadriver }}
                                        </p>
                                        <address>
                                            <strong>Keterangan :</strong><br>
                                            {{ $item->keterangan }}<br>

                                        </address>
                                    </div>
                                    <div class="float-end mt-3">
                                        {{-- <p>
                                        <strong>Kategori : </strong> {{ $item->getrute->getkategori->namakategori }}<br>
                                        <strong>Customer : </strong> {{ $item->getcustomer->namacustomer }}<br>
                                        <strong>Project : </strong> {{ $item->getrute->getproject->namaproject }}<br>
                                        <strong>Driver: </strong> <span
                                            class="label label-pink">{{ $item->getdriver->namadriver }}</span><br>
                                        <strong>Unit : </strong> #{{ $item->getunit->kdunit }} - {{ $item->getunit->plat }} - {{ $item->getunit->merk }}
                                    </p> --}}
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class=" mt-2">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th scope="col">Akun</th>
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
                                                <?php $i = 1;
                                                $total = 0;
                                                $revenue = 0;
                                                $pph = 0;
                                                $pajak = 0;
                                                $ujodriver = 0;
                                                ?>
                                                @foreach ($item->getdetailinvoice as $data)
                                                    <tr>
                                                        <td width="3%">{{ $i }}</td>
                                                        <td width="10%">
                                                            {{ $data->getrate->kdakun }} -
                                                            {{ $data->getrate->getakun->namaakun }}
                                                        </td>
                                                        <td width="3%">
                                                            {{ $data->rateid }}

                                                        </td>
                                                        <td width="15%">

                                                            {{ $data->getrate->namarate }}
                                                        </td>

                                                        <td width="10%" style="text-align: right;">

                                                            {{ number_format($data->nominal, 0) }}
                                                        </td>

                                                        <td width="5%" style="text-align: right;">

                                                            {{ $data->qty }}

                                                        </td>
                                                        <td width="10%" style="text-align: right;">

                                                            {{ number_format($data->jumlah, 0) }}

                                                        </td>
                                                        <td width="5%" style="text-align: right;">

                                                            {{ $data->pph }}

                                                        </td>
                                                        <td width="5%" style="text-align: right;">

                                                            {{ number_format($data->pajak, 0) }}

                                                        </td>

                                                    </tr>
                                                    <?php
                                                    if ($data->getrate->kdakun == '1001') {
                                                        $revenue = $revenue + $data->jumlah;
                                                    } elseif ($data->getrate->kdakun == '5003') {
                                                        $pajak = $pajak + $data->nominal;
                                                    } elseif ($data->getrate->kdakun == '5002') {
                                                        $ujodriver = $ujodriver + $data->jumlah;
                                                    }
                                                    $i++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-6">
                                    <div class="clearfix mt-4">

                                    </div>
                                </div>
                                <div class="col-xl-3 col-6 offset-xl-3">
                                    <p class="text-end"><b>Ujo Driver:</b> {{ number_format($ujodriver) }}</p>
                                    <hr>
                                    <h3 class="text-end">UJO RP {{ number_format($ujodriver) }}</h3>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xl-6 col-6">


                                </div>
                                <div class="col-xl-6 col-6">
                                    <div class="form-group">
                                        <label>Payment Date</label>
                                        <?php echo  date("Y-d-m H:i:s"); ?>
                                        <input type="text" name="noinvoice" class="form-control"
                                            value="{{ $item->noinvoice }}" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Driver Name</label>
                                        <input type="text" name="namadriver" class="form-control"
                                            value="{{ $item->getshipment->getdriver->namadriver }}" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Nominal UJO</label>
                                        <input type="hidden" name="ujo" id="ujo"
                                        value="{{ $item->total-$totalpembayaran}} }}" required style="text-align: right; background:cyan" readonly>
                                            <input type="text" name="vujo" id="vujo"
                                            value="{{ number_format($item->total-$totalpembayaran) }}" required style="text-align: right; background:cyan" readonly>
                                            Total Terbayar:
                                            <input type="text" name="totalpembayaran" id="totalpembayaran"
                                            value="{{ $totalpembayaran }}" required style="text-align: right; background:cyan" readonly>

                                        </div>
                                    <div class="form-group">

                                        <label>Nominal Payment</label>

                                        <input type="text" name="nominal" id="nominal"
                                            value="" required style="text-align: right">
                                            <input type="text" name="vnominal" id="vnominal"
                                            value="" required style="text-align: right; background:cyan" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>BANK</label>
                                        <input type="text" name="bank" class="form-control"
                                           value="{{ $item->getshipment->getdriver->bank }}" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Rekening</label>
                                        <input type="text" name="namarekening" class="form-control"
                                           value="{{ $item->getshipment->getdriver->namarekening }}" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>No. Rekening </label>
                                        <input type="text" name="norekening" class="form-control"
                                        value="{{ $item->getshipment->getdriver->norekening }}" required readonly>
                                    </div>

                                </div>


                            </div>
                            <hr>
                            <div class="d-print-none">
                                <div class="float-end">

                                    <button type="submit" class="btn btn-success waves-effect waves-light"><i
                                            class="fa fa-money"></i> Payment</button>
                                    <a href="{{ route('payment.index') }}"
                                        class="btn btn-primary waves-effect waves-light">Close</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    @endforeach
</form>
<script>
       $('#nominal').keyup(function() {
        var ujo = parseInt($('#ujo').val());
        var nominal = parseInt($(this).val());
        if (nominal > ujo) {
            alert("nominal melebihi ujo");
            $("#nominal").val("");
            $("#nominal").focus();

        }
        if (nominal < 0) {
            alert("nominal ");
            $("#nominal").val("");
            $("#nominal").focus();

        }
        else {
            $('#vnominal').val(accounting.formatMoney(nominal, "Rp ", 0, ".",
                        ","));
        }

    })




</script>
