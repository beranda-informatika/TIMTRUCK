// ignore_for_file: public_member_api_docs, sort_constructors_first
import 'package:flutter/material.dart';
import 'package:sppscorecard_app/pages/mekanik/formmaintenance_page.dart';

import '../models/unit.dart';

class ItemUnitWidget extends StatefulWidget {
  const ItemUnitWidget({
    Key? key,
    required this.unit,
    required this.handleRefresh,
  }) : super(key: key);
  final Unit unit;
  final Function handleRefresh;

  @override
  State<ItemUnitWidget> createState() => _ItemUnitWidgetState();
}

class _ItemUnitWidgetState extends State<ItemUnitWidget> {
  @override
  void initState() {
    super.initState();
  }

  String getstatus() {
    var hm = widget.unit.hm;
    var sts = (hm / 5000) % 2;
    if (sts == 0) {
      return "Overhaul Kecil";
    } else {
      return "Overhaul Besar";
    }
  }

  @override
  Widget build(BuildContext context) {
    return Card(
        child: ListTile(
      onTap: () {
        Navigator.pushNamed(context, '/detailunit', arguments: widget.unit);
      },
      title: Text("${widget.unit.kdunit} / sn: ${widget.unit.serialnumber}"),
      subtitle: Text('HM: ${widget.unit.hm} / ${getstatus()}'),
      trailing: IconButton(
        onPressed: () {
          Navigator.push(context, MaterialPageRoute(builder: (context) {
            return FormMaintenancePage(kdunit: widget.unit.kdunit);
          }));
        },
        icon: const Icon(Icons.arrow_forward_ios),
      ),
    ));
  }
}
