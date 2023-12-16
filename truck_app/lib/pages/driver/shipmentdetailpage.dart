import 'package:flutter/material.dart';

import 'package:sppscorecard_app/models/shipment.dart';

class ShipmentDetailPage extends StatefulWidget {
  const ShipmentDetailPage({
    Key? key,
    required this.shipmentid,
    required this.shipmentmodel,
  }) : super(key: key);
  final String shipmentid;
  final ShipmentModel shipmentmodel;
  @override
  State<ShipmentDetailPage> createState() => _ShipmentDetailPageState();
}

class _ShipmentDetailPageState extends State<ShipmentDetailPage> {
  @override
  void initState() {
    // TODO: implement initState
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: const Color.fromARGB(255, 133, 170, 233),
        title: const Text('Detail Shipment'),
      ),
      body: SafeArea(
        child: Container(
          padding: const EdgeInsets.all(20),
          decoration: BoxDecoration(
            color: Color.fromARGB(255, 150, 198, 227),
            borderRadius: BorderRadius.circular(10),
          ),
          child: Column(
            children: [
              const SizedBox(
                height: 10,
              ),
              Center(
                child: Text('No. Shipment: ${widget.shipmentid}'),
              ),
              const SizedBox(
                height: 10,
              ),
              Text('Origin: ${widget.shipmentmodel.origin}'),
              Text('Destination: ${widget.shipmentmodel.destination}'),
              Text('Status: ${widget.shipmentmodel.f_status}'),
              Text('Driver: ${widget.shipmentmodel.kddriver}'),
              Text('Driver: ${widget.shipmentmodel.kdunit}'),
              Text('Driver: ${widget.shipmentmodel.tglshipment}'),
              Text('UJO Driver: ${widget.shipmentmodel.ujo}'),
            ],
          ),
        ),
      ),
    );
  }
}
