// ignore_for_file: public_member_api_docs, sort_ItemTroubleconstructors_first
import 'package:flutter/material.dart';

import '../models/unit.dart';
import '../pages/mekanik/formtrouble_page.dart';

class ItemTroubleWidget extends StatefulWidget {
  const ItemTroubleWidget({
    Key? key,
    required this.unit,
    required this.handleRefresh,
  }) : super(key: key);
  final Unit unit;
  final Function handleRefresh;

  @override
  State<ItemTroubleWidget> createState() => _ItemTroubleWidgetState();
}

class _ItemTroubleWidgetState extends State<ItemTroubleWidget> {
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
      title: Text("${widget.unit.kdunit} / sn: ${widget.unit.serialnumber}"),
      trailing: IconButton(
        onPressed: () {
          Navigator.push(context, MaterialPageRoute(builder: (context) {
            return FormTroublePage(kdunit: widget.unit.kdunit);
          }));
        },
        icon: const Icon(Icons.arrow_forward_ios),
      ),
    ));
  }
}
