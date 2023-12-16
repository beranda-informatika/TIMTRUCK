
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<table id="example" class="display nowrap table table-striped table-bordered scroll-horizontal font-size-11"
    cellspacing="0" style="border-collapse: collapse;  width: 100%;">
    <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">No.Shipment</th>
            <th scope="col">Date Order</th>
            <th scope="col">Customer</th>
            <th scope="col">Route</th>
            <th scope="col">Project</th>
            <th scope="col">Category</th>
            <th scope="col">MRC</th>
            <th scope="col">Drop</th>
            <th scope="col">Additional MRC</th>
            <th scope="col">Fee</th>
            <th scope="col">Fuel</th>
            <th scope="col">Tol</th>
            <th scope="col">Kapal</th>
            <th scope="col">Komisi</th>
            <th scope="col">Lain-Lain</th>
            <th scope="col">Additional UJO</th>
            <th scope="col">Pajak</th>
            <th scope="col">Revenue</th>
            <th scope="col">Pph 21</th>
            <th scope="col">Ujo Driver</th>
            <th scope="col">Cost</th>
            <th scope="col">Profit/Margin</th>

        </tr>
    </thead>
    <tbody>
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
            <td valign=top align=center>{{ $data->origin }} - {{ $data->destination }} -</td>
            <td valign=top align=center>{{ $data->getproject->namaproject }}</td>
            <td valign=top align=center>{{ $data->getkategori->namakategori }}</td>
            <?php $j = 1;
        $total = 0;
        $revenue = 0;
        $pph = 0;
        $pajak = 0;
        $ujodriver = 0;
        $fee = 0;
        $cost = 0;
        $kolomrate[0]=["namakolom"=>'MRC',"nominal"=>0];
        $kolomrate[1]=["namakolom"=>'Drop',"nominal"=>0];
        $kolomrate[2]=["namakolom"=>'Add.MRC',"nominal"=>0];
        $kolomrate[3]=["namakolom"=>'Fee',"nominal"=>0];
        $kolomrate[4]=["namakolom"=>'Fuel',"nominal"=>0];
        $kolomrate[5]=["namakolom"=>'Tol',"nominal"=>0];
        $kolomrate[6]=["namakolom"=>'Kapal',"nominal"=>0];
        $kolomrate[7]=["namakolom"=>'Komisi',"nominal"=>0];
        $kolomrate[8]=["namakolom"=>'Lain-Lain',"nominal"=>0];
        $kolomrate[9]=["namakolom"=>'Add.UJO',"nominal"=>0];
        $kolomrate[10]=["namakolom"=>'Pajak Pph.21',"nominal"=>0];




        foreach ($data->getdetailshipment as $item) {
            if ($item->rateid == '10011') {
                $kolomrate[0]["nominal"] = $item->jumlah;
            } elseif ($item->rateid == '10012') {
                $kolomrate[1]["nominal"] = $item->jumlah;
            } elseif ($item->rateid == '10013') {
                $kolomrate[2]["nominal"] = $item->jumlah;
            } elseif ($item->rateid == '50011') {
                $kolomrate[3]["nominal"] = $item->jumlah;
            } elseif ($item->rateid == '50021') {
                $kolomrate[4]["nominal"] = $item->jumlah;
            } elseif ($item->rateid == '50022') {
                $kolomrate[5]["nominal"] = $item->jumlah;
            } elseif ($item->rateid == '50023') {
                $kolomrate[6]["nominal"] = $item->jumlah;
            } elseif ($item->rateid == '50024') {
                $kolomrate[7]["nominal"] = $item->jumlah;
            } elseif ($item->rateid == '50025') {
                $kolomrate[8]["nominal"] = $item->jumlah;
            } elseif ($item->rateid == '50026') {
                $kolomrate[9]["nominal"] = $item->jumlah;
            } elseif ($item->rateid == '50031') {
                $kolomrate[10]["nominal"] = $item->jumlah;
            }
            $j++;
            if ($item->getrate->getakun->kelakun == '1000') {
                $revenue = $revenue + $item->jumlah;
            } elseif ($item->getrate->kdakun == '5003') {
                $pajak = $pajak + $item->nominal;
            } elseif ($item->getrate->kdakun == '5002') {
                $ujodriver = $ujodriver + $item->jumlah;
            } elseif ($item->getrate->kdakun == '5001') {
                $fee = $fee + $item->jumlah;
            }

        }

        for($k=0;$k<11;$k++){ ?>
            <td style="text-align: right;">{{ number_format($kolomrate[$k]['nominal']) }}</td>
            <?php } ?>
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
                <?php $cost = $fee + $pajak + $ujodriver; ?>
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
        ?>
        <?php } ?>

    </tbody>
</table>
<table style="border: 1px solid" width="50%">
    <tr>
        <td>Revenue</td>
        <td>Pajak</td>
        <td>UJO Driver</td>
        <td>Cost</td>
        <td>Profit/Margin</td>
    </tr>
    <tr>



        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalrevenue); ?></b></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalpajak); ?></b></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalujodriver); ?></b></td>

        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalcost); ?></b></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalprofit); ?></b></td>
    </tr>
</table>
<br>


<script>
$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    });

} );
</script>
