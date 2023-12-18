@foreach ($groupquotation as $itemgroupquotation)

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
                            <div class="col-6">
                                <img src="{{ public_path('build/images/logo.jpg') }}" style="width: 200px;">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div style="text-align: right">Cikarang, {{ date_format(date_create(now()), 'd M Y') }}</div><br>
                                No: <strong>{{ $itemgroupquotation->groupquotationid }}</strong><br>

                                <br>
                                <br>
                                Kepada Yth: <br>
                                {{ $itemgroupquotation->getcustomer->namacustomer }}<br>
                                {{ $itemgroupquotation->getcustomer->address }}<br>


                                <div class="float-start mt-3">
                                    <p>
                                        <strong>Subject: </strong> Penawaran Sewa Truck
                                        <br>
                                        <br>


                                      Dengan hormat,<br>
                                        Bersama dengan ini kami sampaikan adalah penawaran harga sewa truck sebagai berikut:

                                    </p>



                                </div>
                                <div class="float-end mt-3">

                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">


                                <table class="table" width="700px" border=1 cellpadding=2 cellspacing=0 style="font-size: 11px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th scope="col">Origin</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Type Truck</th>
                                            <th scope="col">Type Route</th>
                                            <th scope="col" style="text-align: right;">MRC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
                                        @foreach ($quotation as $item)
                                            <tr >
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->origin }}</td>
                                                <td>{{ $item->destination }}</td>
                                                <td>{{ $item->gettypetruck->namatypetruck }}</td>
                                                <td>@if ($item->typeroute=="load")
                                                    Rate/Kg
                                                @else
                                                    Trip
                                                @endif
                                                </td>
                                                <td style="text-align: right;">{{ number_format($item->mrc) }}</td>
                                            </tr>
                                            @php $i++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>


                        </div>
                        <br>
                            <p>
                            <strong>Keterangan :</strong><br>
                            {!! $itemgroupquotation->description !!}<br>
                            </p>


                        <div class="float-start mt-3">
                            <p>Demikian penawaran ini kami sampaikan dan kami tunggu kabar selanjutnya, atas segala perhatian dan kesempatan yang diberikan kami ucapkan banyak terima kasih.<br>
                                <br>
                                <table width="100%" style="text-align: center">
                                    <tr>
                                        <td>Hormat Kami,<br>
                                            <strong>{{ $itemgroupquotation->getkategori->namakategori }}</strong>
                                        </td>
                                        <td>Yang Menyetujui,<br>
                                            <strong>{{ $itemgroupquotation->getcustomer->namacustomer }}</strong>
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
