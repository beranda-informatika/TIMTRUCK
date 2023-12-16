<table width="900" border="0" cellpadding="0" cellspacing="0" style="font-size: 11px">
    <tr>
        <td align="center" colspan="3">
            <h2>Report Income Statement</h2></strong></p>
        </td>
    </tr>
    <tr>
        <td width="100">Period</td>
        <td width="11">:</td>
        <td width="589">{{ date_format(date_create($tglmulai), 'd-m-Y') }} -
            {{ date_format(date_create($tglakhir), 'd-m-Y') }}
        </td>
    </tr>
</table>
<table width="900" height="21" border="1" cellspacing="0" bordercolor="#000000" class="grid"
    style="font-size: 10px">
    <tr bgcolor="#CCCCCC">
        <th width="5%" height="30">No.</th>
        <th width="10%">
            <p>No.Shipment</p>
        </th>
        <th width="5%">
            <p>Date Order</p>
        </th>
        <th width="10%">
            <p>Customer</p>
        </th>
        <th width="10%">
            <p>Route</p>
        </th>
        <th width="30">
            <p>Project</p>
        </th>
        <th width="50">
            <p>Category</p>
        </th>
        <th width="50%">
            <p>Rates</p>
        </th>
        <th>
            <p>Revenue</p>
        </th>
        <th>
            <p>Pph 21</p>
        </th>
        <th>
            <p>Ujo Driver</p>
        </th>
        <th>
            <p>Cost</p>
        </th>
        <th>
            <p>Profit/Margin</p>
        </th>

    </tr>

    <?php

    $totalrevenue=0;
    $totalcost=0;
    $totalprofit=0;
    $totalpajak=0;
    $totalujodriver=0;


    $i=1;
    foreach ($shipment as $data) {
        # code...
        //... batas halaman
        if(($i%30)==1){
            if($i > 1){
                echo '<div class=\"pagebreak\"> </div>';
            };
        };
        ?>

    <tr>
        <td align=center valign=top>{{ $i }}</td>
        <td align=center valign=top>{{ $data->shipmentid }}</td>
        <td align=center valign=top>{{ date_format(date_create($data->tglorder), 'd-m-Y') }}
        </td>
        <td valign=top>{{ $data->getcustomer->namacustomer }}</td>
        <td valign=top align=center>{{ $data->origin }} -  {{ $data->destination }} -</td>
        <td valign=top align=center>{{ $data->getproject->namaproject }}</td>
        <td valign=top align=center>{{ $data->getkategori->namakategori }}</td>


        <td style="text-align: center">
            <table border="0" cellspacing="0" style="font-size: 10px" width="100%">
                <tr>

                    <th>#</th>
                    <th scope="col">Rates</th>
                    <th scope="col">Nominal</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">pph (%)</th>
                    <th scope="col">Amount PPh</th>


                </tr>
                <?php $j = 1;
                $total = 0;
                $revenue = 0;
                $pph = 0;
                $pajak = 0;
                $ujodriver = 0;
                $fee = 0;
                $cost = 0;
                ?>
                @foreach ($data->getdetailshipment as $data)



                    <tr>
                        <td width="3%">{{ $j }}</td>
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
                    $j++;
                    if ($data->getrate->getakun->kelakun == '1000') {
                        $revenue = $revenue + $data->jumlah;
                    }
                    elseif ($data->getrate->kdakun == '5003') {
                        $pajak = $pajak + $data->nominal;
                    } elseif ($data->getrate->kdakun == '5002') {
                        $ujodriver = $ujodriver + $data->jumlah;

                } elseif ($data->getrate->kdakun == '5001') {
                        $fee = $fee + $data->jumlah;
                    }
                    ?>
                @endforeach
            </table>
        </td>
        <td style="text-align: right;">
             {{ number_format($revenue, 0) }} <br>
        </td>
        <td style="text-align: right;">
             {{ number_format($pajak, 0) }} <br>
        </td>
        <td style="text-align: right;">
            {{ number_format($ujodriver, 0) }} <br>
        </td>
        <td style="text-align: right;">
            <?php $cost = $fee + $pajak+$ujodriver; ?>
            {{ number_format($cost, 0) }} <br>
        </td>
        <td style="text-align: right;">
            <?php $profit = $revenue - $cost; ?>
            {{ number_format($profit, 0) }} <br>
        </td>
    </tr>
    <?php
        $i++;
        $totalrevenue = $totalrevenue + $revenue;
        $totalcost = $totalcost + $cost;
        $totalprofit = $totalprofit + $profit;
        $totalpajak = $totalpajak + $pajak;
        $totalujodriver = $totalujodriver + $ujodriver;


        //... loop
        }
        ?>
    <tr>
        <td colspan="8" align="right"></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalrevenue); ?></b></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalpajak); ?></b></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalujodriver); ?></b></td>

        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalcost); ?></b></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalprofit); ?></b></td>
    </tr>
</table>
