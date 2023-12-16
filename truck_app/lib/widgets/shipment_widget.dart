import 'package:flutter/material.dart';

import 'package:sppscorecard_app/models/shipment.dart';

class ShipmentWidge extends StatefulWidget {
  const ShipmentWidge({
    Key? key,
    required this.shipmentmodel,
  }) : super(key: key);
  final ShipmentModel shipmentmodel;

  @override
  State<ShipmentWidge> createState() => _ShipmentWidgeState();
}

class _ShipmentWidgeState extends State<ShipmentWidge> {
  @override
  Widget build(BuildContext context) {
    return Card(
        child: ListTile(
      title: Text(
          "${widget.shipmentmodel.origin} / sn: ${widget.shipmentmodel.destination}"),
      trailing: IconButton(
        onPressed: () {},
        icon: const Icon(Icons.arrow_forward_ios),
      ),
    ));
  }
}
