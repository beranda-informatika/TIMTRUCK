// ignore_for_file: public_member_api_docs, sort_ItemTroubleconstructors_first
import 'package:flutter/material.dart';
import 'package:sppscorecard_app/pages/mekanik/formsparepart_page.dart';

import '../models/unit.dart';

class ItemUnitSparepartPage extends StatefulWidget {
  const ItemUnitSparepartPage({
    Key? key,
    required this.unit,
    required this.handleRefresh,
  }) : super(key: key);
  final Unit unit;
  final Function handleRefresh;

  @override
  State<ItemUnitSparepartPage> createState() => _ItemUnitSparepartPageState();
}

class _ItemUnitSparepartPageState extends State<ItemUnitSparepartPage> {
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
            return FormSparepartPage(kdunit: widget.unit.kdunit);
          }));
        },
        icon: const Icon(Icons.arrow_forward_ios),
      ),
    ));
  }
}
