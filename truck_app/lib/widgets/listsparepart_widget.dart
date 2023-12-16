// ignore_for_file: public_member_api_docs, sort_ItemTroubleconstructors_first
import 'package:flutter/material.dart';
import 'package:sppscorecard_app/models/sparepart.dart';

class ItemSparepartPage extends StatefulWidget {
  const ItemSparepartPage({
    Key? key,
    required this.sparepart,
    required this.handleRefresh,
  }) : super(key: key);
  final Sparepart sparepart;
  final Function handleRefresh;

  @override
  State<ItemSparepartPage> createState() => _ItemSparepartPageState();
}

class _ItemSparepartPageState extends State<ItemSparepartPage> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Card(
        child: ListTile(
      title: Text(
          "${widget.sparepart.codepart} / sn: ${widget.sparepart.partname}"),
      trailing: IconButton(
        onPressed: () {
          // Navigator.push(context, MaterialPageRoute(builder: (context) {
          //   return FormSparepartPage(kdunit: widget.unit.kdunit);
          // }));
        },
        icon: const Icon(Icons.arrow_forward_ios),
      ),
    ));
  }
}
