<table width="900" border="0" cellpadding="0" cellspacing="0" style="font-size: 11px">
    <tr>
        <td align="center" colspan="3">
            <h2>Report Shipment </h2></strong></p>
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
<table width="1400" height="21" border="1" cellspacing="0" bordercolor="#000000" class="grid"
    style="font-size: 10px">
    <tr bgcolor="#CCCCCC">
        <th width="5%" height="30">No.</th>
        <th width="100">
            <p>No.Shipment</p>
        </th>
        <th width="100">
            <p>Customer</p>
        </th>

        <th width="100">
            <p>Project</p>
        </th>
        <th width="100">
            <p>Kategori</p>
        </th>


        <th width="50">
            <p>Driver</p>
        </th>
        <th width="50">
            <p>Unit</p>
        </th>
        <th>Plat</th>
        <th>Merk</th>
        <th width="150">Type</th>
        <th width="70">
            <p>Date Approve</p>
        </th>
        <th width="70">
            <p>Date Shipment</p>
        </th>

        <th>Status</th>
    </tr>

    <?php
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
        <td valign=top>{{ $data->getcustomer->namacustomer }}</td>

        <td valign=top align=center>{{ $data->getproject->namaproject }}</td>
        <td valign=top align=center>{{ $data->getkategori->kdkategori }}</td>

        <td valign=top>{{ $data->getdriver->namadriver }}</td>
        <td valign=top>{{ $data->getunit->kdunit }}</td>
        <td valign=top>{{ $data->getunit->plat }}</td>
        <td valign=top>{{ $data->getunit->merk }}</td>
        <td valign=top>{{ $data->getunit->typeunit }}</td>
        <td align=center valign=top>
            @if ($data->tglorder)
                {{ date_format(date_create($data->tglorder), 'd-m-Y') }}
            @endif
        </td>
        <td align=center valign=top>
            @if ($data->tglshipment)
                {{ date_format(date_create($data->tglshipment), 'd-m-Y') }}
            @endif
        </td>

        <td valign=top>{{ $data->f_status }}</td>

    </tr>
    <?php
        $i++;
        }
        ?>
</table>
