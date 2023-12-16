<table class="table" style="font-size: 10px">
    <thead class="active">
        <tr>
            <td>Driver</td>
            <th>Shipment ID</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>status</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($shipment as $item)
            <tr>
                <td>{{ $item->kddriver }}</td>
                <td>{{ $item->shipmentid }} </td>
                <td>{{ $item->origin }} </td>
                <td>{{ $item->destination }}</td>
                <td>{{ $item->f_status }}</td>
            </tr>
        @endforeach
</table>
