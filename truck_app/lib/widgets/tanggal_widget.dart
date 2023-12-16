// ignore_for_file: public_member_api_docs, sort_constructors_first
import 'package:flutter/material.dart';

class Tanggal extends StatefulWidget {
  final void Function(DateTime selectedDate) selectedDate;
  const Tanggal({
    Key? key,
    required this.selectedDate,
  }) : super(key: key);

  @override
  State<Tanggal> createState() => _TanggalState();
}

class _TanggalState extends State<Tanggal> {
  DateTime? selectedDate;

  void _pilihDate(BuildContext context) async {
    final DateTime? date = await showDatePicker(
      context: context,
      initialDate: selectedDate!,
      firstDate: DateTime(2021),
      lastDate: DateTime(2040),
    );
    if (date != null && date != selectedDate) {
      setState(() {
        selectedDate = date;
      });
    }
    widget.selectedDate(selectedDate!);
  }

  @override
  void initState() {
    selectedDate = DateTime.now();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return TextButton(
      onPressed: () {
        _pilihDate(context);
      },
      child: const Text(
        'Pilih Tanggal',
        style: TextStyle(
          color: Colors.black,
          fontSize: 20,
        ),
      ),
    );
  }
}
