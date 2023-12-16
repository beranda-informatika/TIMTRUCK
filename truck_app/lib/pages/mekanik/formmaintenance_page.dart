// ignore_for_file: public_member_api_docs, sort_constructors_first

import 'package:flutter/material.dart';
import 'package:sppscorecard_app/pages/mekanik/formupload_gambar.dart';
import 'package:sppscorecard_app/services/maintenance_dio.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../models/unit.dart';

class FormMaintenancePage extends StatefulWidget {
  const FormMaintenancePage({
    Key? key,
    required this.kdunit,
  }) : super(key: key);
  final String kdunit;

  @override
  State<FormMaintenancePage> createState() => _FormMaintenancePageState();
}

class _FormMaintenancePageState extends State<FormMaintenancePage> {
  final formkey = GlobalKey<FormState>();
  late int idaction = 0;
  late DateTime selectedtanggalpengerjaan = DateTime.now();
  late DateTime selectedwaktupengerjaan = DateTime.now();
  late TimeOfDay selectedTime = TimeOfDay.now();
  String filename = '';
  int? userid = 0;
  setter() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      userid = prefs.getInt('userid');
    });
  }

  _pilihtanggalpengerjaan() async {
    final DateTime? date = await showDatePicker(
      context: context,
      initialDate: selectedtanggalpengerjaan,
      firstDate: DateTime(2021),
      lastDate: DateTime(2040),
    );
    if (date != null && date != selectedtanggalpengerjaan) {
      setState(() {
        selectedtanggalpengerjaan = date;
        _tanggalpengerjaan.text =
            '${selectedtanggalpengerjaan.day}-${selectedtanggalpengerjaan.month}-${selectedtanggalpengerjaan.year}';
      });
    }
  }

  _pilihwaktupengerjaan() async {
    final DateTime? date = await showDatePicker(
      context: context,
      initialDate: selectedwaktupengerjaan,
      firstDate: DateTime(2021),
      lastDate: DateTime(2040),
    );
    if (date != null && date != selectedwaktupengerjaan) {
      setState(() {
        selectedwaktupengerjaan = date;
        _waktuselesaipengerjaan.text =
            '${selectedwaktupengerjaan.day}-${selectedwaktupengerjaan.month}-${selectedwaktupengerjaan.year}';
      });
    }
  }

  final _tanggalpengerjaan = TextEditingController();
  final _waktuselesaipengerjaan = TextEditingController();
  final _deskripsi = TextEditingController();
  final _sparepart = TextEditingController();
  final _hm = TextEditingController();

  List<String> dokumen = [];
  List<Unit> _unit = [];

  String status = "";
  String _shift = '1';
  String kdunit = '';
  final shiftlist = <String>[
    '1',
    '2',
    '3',
  ];
  final dokumentlist = <String>[
    'Before Unit',
    'Kegiatan Pengerjaan',
    'After Unit',
    'Service Report',
    'Checklist',
    'Dokumen Lainnya'
  ];
  bool isLoading = false;

  void refreshData() {
    setState(() {
      isLoading = true;
      kdunit = widget.kdunit;
    });
    MaintenanceDio().getunit(kdunit).then((value) {
      setState(() {
        _unit = value;
        isLoading = false;
      });
    });
  }

  @override
  void initState() {
    super.initState();
    setter();
    refreshData();
  }

  final _formKey = GlobalKey<FormState>();
  @override
  Widget build(BuildContext context) {
    return Form(
      key: _formKey,
      child: Scaffold(
        appBar: AppBar(
          elevation: 0,
          title: const Text('Form Maintenance'),
          actions: [
            IconButton(
              onPressed: () {
                Navigator.pop(context);
              },
              icon: const Icon(Icons.close),
            ),
          ],
        ),
        body: ListView(
          children: [
            Container(
              margin: const EdgeInsets.all(10),
              height: 70,
              width: 250,
              child: Card(
                margin: const EdgeInsets.only(top: 5, bottom: 5),
                color: const Color.fromARGB(255, 245, 224, 250),
                elevation: 5,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(10),
                ),
                child: _unit.isEmpty
                    ? const Center(child: CircularProgressIndicator())
                    : Column(
                        children: [
                          const SizedBox(height: 10),
                          Text('Kd Unit : ${_unit[0].kdunit}',
                              textAlign: TextAlign.left,
                              style: const TextStyle(
                                fontSize: 10,
                                fontWeight: FontWeight.bold,
                              )),
                          Text('Serial Number : ${_unit[0].serialnumber}',
                              textAlign: TextAlign.left,
                              style: const TextStyle(
                                fontSize: 10,
                                fontWeight: FontWeight.bold,
                              )),
                          Text('HM: ${_unit[0].hm}',
                              style: const TextStyle(
                                fontSize: 10,
                                fontWeight: FontWeight.bold,
                              )),
                        ],
                      ),
              ),
            ),
            Container(
                margin: const EdgeInsets.all(15),
                decoration:
                    BoxDecoration(borderRadius: BorderRadius.circular(10)),
                child: Column(
                  children: [
                    TextFormField(
                      enabled: true,
                      controller: _tanggalpengerjaan,
                      decoration: const InputDecoration(
                          hintText: 'Tanggal Pengerjaan',
                          border: OutlineInputBorder(),
                          suffixIcon: Icon(Icons.calendar_today),
                          labelText: 'Tanggal Pengerjaan'),
                      onTap: () {
                        _pilihtanggalpengerjaan();
                      },
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Tanggal Pengerjaan tidak boleh kosong';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 10),
                    const Text('Shift'),
                    DropdownButton(
                      value: _shift,
                      items: shiftlist
                          .map((e) => DropdownMenuItem(
                                value: e,
                                child: Text(e),
                              ))
                          .toList(),
                      onChanged: (String? val) {
                        setState(() {
                          if (val != null) {
                            _shift = val;
                          }
                        });
                      },
                    ),
                    TextFormField(
                      enabled: true,
                      controller: _deskripsi,
                      decoration: const InputDecoration(
                          hintText: 'Deskripsi Pengerjaan',
                          border: OutlineInputBorder(),
                          suffixIcon: Icon(Icons.abc),
                          labelText: 'Deskripsi Pengerjaan'),
                      onTap: () {},
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Deskripsi Pengerjaan tidak boleh kosong';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 10),
                    TextFormField(
                      enabled: true,
                      controller: _sparepart,
                      decoration: const InputDecoration(
                          hintText: 'Pemakaian Sparepart',
                          border: OutlineInputBorder(),
                          suffixIcon: Icon(Icons.abc),
                          labelText: 'Pemakaian Sparepart'),
                      onTap: () {},
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Pemakaian  tidak boleh kosong';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 10),
                    TextFormField(
                      enabled: true,
                      controller: _waktuselesaipengerjaan,
                      decoration: const InputDecoration(
                          hintText: 'Waktu Selesai Pengerjaan',
                          border: OutlineInputBorder(),
                          suffixIcon: Icon(Icons.calendar_today),
                          labelText: 'Waktu Selesai Pengerjaan'),
                      onTap: () {
                        _pilihwaktupengerjaan();
                      },
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Waktu Selesai Pengerjaan tidak boleh kosong';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 10),
                    TextFormField(
                      enabled: true,
                      controller: _hm,
                      decoration: const InputDecoration(
                          hintText: 'HM terbaru',
                          border: OutlineInputBorder(),
                          suffixIcon: Icon(Icons.numbers),
                          labelText: 'HM terbaru'),
                      onTap: () {},
                      keyboardType: TextInputType.number,
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'HM  tidak boleh kosong';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 10),
                    const Text('Status: '),
                    Container(
                      margin: const EdgeInsets.only(left: 20, right: 20),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Radio(
                              value: "OPEN",
                              groupValue: status,
                              onChanged: (value) {
                                setState(() {
                                  status = value.toString();
                                });
                              }),
                          const Text('OPEN'),
                          const SizedBox(height: 10),
                          Radio(
                              value: "CLOSE",
                              groupValue: status,
                              onChanged: (value) {
                                setState(() {
                                  status = value.toString();
                                });
                              }),
                          const Text('CLOSE'),
                        ],
                      ),
                    ),
                    const SizedBox(height: 10),
                    Container(
                      padding: const EdgeInsets.all(5),
                      width: double.infinity,
                      height: 50,
                      decoration: const BoxDecoration(
                          color: Color.fromARGB(255, 250, 115, 5)),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          TextButton.icon(
                              onPressed: () {
                                if (_shift.isEmpty ||
                                    _waktuselesaipengerjaan.text.isEmpty ||
                                    _sparepart.text.isEmpty ||
                                    _deskripsi.text.isEmpty ||
                                    status.isEmpty) {
                                  ScaffoldMessenger.of(context).showSnackBar(
                                    const SnackBar(
                                      content: Text(
                                          'Harap isi semua data terlebih dahulu'),
                                    ),
                                  );
                                  return;
                                }

                                final Map<String, dynamic> itemdetail = {
                                  'kdunit': widget.kdunit,
                                  'iduser': userid!,
                                  'tanggalmulai': _tanggalpengerjaan.text,
                                  'tanggalakhir': _waktuselesaipengerjaan.text,
                                  'shift': _shift,
                                  'actionplan': _deskripsi.text,
                                  'sparepart': _sparepart.text,
                                  'hm': _hm.text,
                                  'statusmekanik': status,
                                };
                                setState(() => isLoading = true);
                                MaintenanceDio()
                                    .postData(itemdetail)
                                    .then((value) {
                                  setState(() {
                                    idaction = value['idaction'];
                                    Navigator.push(
                                        context,
                                        MaterialPageRoute(
                                            builder: (context) =>
                                                FormUploadMaintenance(
                                                  idaction: idaction,
                                                )));
                                  });
                                });
                              },
                              icon: const Icon(
                                Icons.fast_forward,
                                color: Colors.white,
                              ),
                              label: const Text(
                                'Simpan Proses Pengerjaan',
                                style: TextStyle(color: Colors.white),
                              )),
                        ],
                      ),
                    ),
                  ],
                )),
          ],
        ),
      ),
    );
  }
}
