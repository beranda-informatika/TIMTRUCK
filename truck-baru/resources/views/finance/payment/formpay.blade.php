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
                                            <strong>Date Request: </strong> {{ $item->tglinvoice }}<br>
                                            <strong>NO UJO: </strong> {{ $item->noujo }} <br>
                                            <input type="hidden" name="noujo" id="noujo"
                                                value="{{ $item->noujo }}" required readonly>
                                            <strong>Driver : </strong> {{ $item->getujo->getshipment->getdriver->namadriver }}
                                        </p>
                                        <address>
                                            <strong>Keterangan :</strong><br>
                                            {{ $item->keterangan }}<br>

                                        </address>
                                    </div>

                                </div><!-- end col -->
                            </div>
                            <!-- end row -->
                            <div class="row">
                                <div class="col-xl-6 col-6">
                                    <div class="clearfix mt-4">

                                    </div>
                                </div>
                                <div class="col-xl-3 col-6 offset-xl-3">
                                    <p class="text-end"><b>Total :</b> {{ number_format($item->total) }}</p>
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
                                            value="{{ $item->getujo->getshipment->getdriver->namadriver }}" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Total</label>
                                        <input type="hidden" name="total" id="total"
                                        value="{{ $item->total }}" required  readonly>
                                            <input type="text" name="totalpembayaran" id="totalpembayaran"
                                            value="{{ number_format($item->total) }}" required style="text-align: right; background:cyan" readonly>

                                        </div>

                                    <div class="form-group">
                                        <label>BANK</label>
                                        <input type="text" name="bank" class="form-control"
                                           value="{{ $item->getujo->getshipment->getdriver->bank }}" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Rekening</label>
                                        <input type="text" name="namarekening" class="form-control"
                                           value="{{ $item->getujo->getshipment->getdriver->namarekening }}" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>No. Rekening </label>
                                        <input type="text" name="norekening" class="form-control"
                                        value="{{ $item->getujo->getshipment->getdriver->norekening }}" required readonly>
                                    </div>

                                </div>


                            </div>
                            <hr>
                            <div class="d-print-none">
                                <div class="float-end">

                                    <button type="submit" class="btn btn-success waves-effect waves-light"><i
                                            class="fa fa-money"></i> Pay</button>
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
