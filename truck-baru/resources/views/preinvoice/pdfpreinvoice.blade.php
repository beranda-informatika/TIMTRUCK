@foreach ($preinvoice as $itempreinvoice)
<br>

<style>
   body {
        font-size: 12px;
        font-family: Arial, Helvetica, sans-serif;
    }

    </style>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">

                    <div class="panel-body">


                        <div class="row">
                            <div class="col-md-12">
                                <div style="text-align: right">Cikarang, {{ date_format(date_create(now()), 'd M Y') }}</div><br>
                                <strong>{{ $itempreinvoice->getkategori->namakategori }}</strong><br>
                                Pre-Invoice No: <strong>{{ $itempreinvoice->piid }}</strong><br>
                                Project: <strong>{{ $itempreinvoice->project }}</strong><br>


                                <br>
                                Kepada Yth: <br>
                                {{ $itempreinvoice->getcustomer->namacustomer }}<br>
                                {{ $itempreinvoice->getcustomer->address }}<br>

                                <div class="float-end mt-3">

                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">


                                <table class="table" width="1000px" border=1 cellpadding=2 cellspacing=0 style="font-size: 11px">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">DO/STDN No</th>
                                            <th scope="col">Shipper</th>
                                            <th scope="col">Origin</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Vehicle Type</th>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Multi Drop</th>
                                            <th scope="col">Unloading</th>
                                            <th scope="col">Addcost</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; $jumlah=0; $total=0;$ppn=0; @endphp
                                        @foreach ($shipment as $item)
                                            <tr >
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->getshipment->tglorder }}</td>
                                                <td>{{ $item->shipmentid }}</td>
                                                <td>{{ $item->getshipment->kdkategori }}</td>
                                                <td>{{ $item->getshipment->origin }}</td>
                                                <td>{{ $item->getshipment->destination }}</td>
                                                <td>{{ $item->getshipment->typetruckid }}</td>
                                                <td style="text-align: right;">{{ number_format($item->getshipment->mrc) }}</td>
                                                <td style="text-align: right;">
                                                    @php $multidrop=$item->getshipment->qtydrop*$item->getshipment->ratedrop;
                                                    @endphp
                                                    {{ number_format($multidrop) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    @php $unloading=$item->getshipment->qtypickup*$item->getshipment->ratepickup;
                                                    @endphp
                                                    {{ number_format($unloading) }}
                                                    </td>
                                                <td style="text-align: right;">{{ number_format($item->getshipment->addcost) }}</td>
                                                @php
                                                    $total=$item->getshipment->mrc+$multidrop+$unloading+$item->getshipment->addcost;
                                                @endphp
                                                <td style="text-align: right;">{{ number_format($total) }}</td>

                                            </tr>
                                            @php $i++; $jumlah=$jumlah+$total; @endphp
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td colspan="10" style="text-align: right">Total</td>
                                            <td style="text-align: right">{{ number_format($jumlah) }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="10" style="text-align: right">PPN 11%</td>
                                            <td style="text-align: right">
                                                @php
                                                    $ppn=$jumlah*11/100;
                                                @endphp
                                                {{ number_format($ppn) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="10" style="text-align: right">Total Invoice</td>
                                            <td style="text-align: right">{{ number_format($jumlah+$ppn) }}</td>
                                        </tr>

                                    </tbody>
                                </table>


                        </div>

                        <br>
                        <br>

                        <div class="float-start mt-3">
                                <table width="100%" style="text-align: center">
                                    <tr>
                                        <td>Prepared by,<br>
                                            <strong>{{ $itempreinvoice->getkategori->namakategori }}</strong>
                                        </td>
                                        <td>Approve by,<br>
                                            <strong>{{ $itempreinvoice->getcustomer->namacustomer }}</strong>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td><br><br><br><br><br>-</td>
                                        <td><br><br><br><br>
                                            ( ............................... )</td>
                                    </tr>
                                </table>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endforeach
