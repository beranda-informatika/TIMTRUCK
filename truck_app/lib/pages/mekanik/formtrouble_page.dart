// ignore_for_file: public_member_api_docs, sort_constructors_first

import 'package:flutter/material.dart';
import 'package:sppscorecard_app/pages/mekanik/formuploadtrouble.dart';
import 'package:sppscorecard_app/services/maintenance_dio.dart';
import 'package:sppscorecard_app/services/trouble_dio.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../models/unit.dart';

class FormTroublePage extends StatefulWidget {
  const FormTroublePage({
    Key? key,
    required this.kdunit,
  }) : super(key: key);
  final String kdunit;

  @override
  State<FormTroublePage> createState() => _FormTroublePageState();
}

class _FormTroublePageState extends State<FormTroublePage> {
  final formkey = GlobalKey<FormState>();
  late int idaction = 0;
  late DateTime selectedtanggalpengerjaan = DateTime.now();
  late DateTime selectedwaktupengerjaan = DateTime.now();
  late TimeOfDay selectedTime = TimeOfDay.now();
  late TimeOfDay selectedTimeakhir = TimeOfDay.now();
  String filename = '';
  int? userid = 0;
  setter() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      userid = prefs.getInt('userid');
    });
  }

  pilihjampengerjaan() async {
    final TimeOfDay? time = await showTimePicker(
      context: context,
      initialTime: selectedTime,
    );
    if (time != null) {
      setState(() {
        selectedTime = time;
        _jampengerjaan.text = '${selectedTime.hour}:${selectedTime.minute}';
      });
    }
  }

  pilihjamselesai() async {
    final TimeOfDay? time = await showTimePicker(
      context: context,
      initialTime: selectedTimeakhir,
    );
    if (time != null) {
      setState(() {
        selectedTimeakhir = time;
        _jamselesai.text =
            '${selectedTimeakhir.hour}:${selectedTimeakhir.minute}';
      });
    }
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
    if (date != null) {
      setState(() {
        selectedwaktupengerjaan = date;
        _waktuselesaipengerjaan.text =
            '${selectedwaktupengerjaan.day}-${selectedwaktupengerjaan.month}-${selectedwaktupengerjaan.year}';
      });
    }
  }

  final _tanggalpengerjaan = TextEditingController();
  final _waktuselesaipengerjaan = TextEditingController();
  final _jampengerjaan = TextEditingController();
  final _jamselesai = TextEditingController();

  final _deskripsi = TextEditingController();
  final _sparepart = TextEditingController();

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
          title: const Text('Form Trouble'),
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
              height: 60,
              width: 250,
              child: Card(
                margin: const EdgeInsets.only(top: 5, bottom: 5),
                color: const Color.fromARGB(255, 247, 14, 14),
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
                                color: Colors.white,
                              )),
                          Text('Serial Number : ${_unit[0].serialnumber}',
                              textAlign: TextAlign.left,
                              style: const TextStyle(
                                  fontSize: 10,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white)),
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
                    TextFormField(
                      enabled: true,
                      controller: _jampengerjaan,
                      decoration: const InputDecoration(
                          hintText: 'Jam Mulai Pengerjaan',
                          border: OutlineInputBorder(),
                          suffixIcon: Icon(Icons.timer),
                          labelText: 'Jam Mulai Pengerjaan'),
                      onTap: () {
                        pilihjampengerjaan();
                      },
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Jam mulai Pengerjaan tidak boleh kosong';
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
                      controller: _jamselesai,
                      decoration: const InputDecoration(
                          hintText: 'Jam Selesai Pengerjaan',
                          border: OutlineInputBorder(),
                          suffixIcon: Icon(Icons.timer),
                          labelText: 'Jam Selesai Pengerjaan'),
                      onTap: () {
                        pilihjamselesai();
                      },
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Jam Selesai Pengerjaan tidak boleh kosong';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 10),
                    const Text('Status: '),
                    Container(
                      margin: const EdgeInsets.only(left: 60, right: 60),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceAround,
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
                                    _tanggalpengerjaan.text.isEmpty ||
                                    _jampengerjaan.text.isEmpty ||
                                    _jamselesai.text.isEmpty ||
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
                                  'periode': '2023-07',
                                  'iduser': userid!,
                                  'tanggalmulai': _tanggalpengerjaan.text,
                                  'jammulai': _jampengerjaan.text,
                                  'jamselesai': _jamselesai.text,
                                  'tanggalakhir': _waktuselesaipengerjaan.text,
                                  'shift': _shift,
                                  'actionplan': _deskripsi.text,
                                  'sparepart': _sparepart.text,
                                  'statusmekanik': status,
                                };
                                setState(() => isLoading = true);
                                TroubleDio().postData(itemdetail).then((value) {
                                  setState(() {
                                    idaction = value['idaction'];
                                    Navigator.push(
                                        context,
                                        MaterialPageRoute(
                                            builder: (context) =>
                                                FormUploadTrouble(
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
