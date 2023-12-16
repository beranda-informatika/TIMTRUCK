// ignore_for_file: public_member_api_docs, sort_constructors_first
import 'dart:io';

import 'package:flutter/material.dart';
import 'package:sppscorecard_app/pages/dashboard_page.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../models/dokumenmaintenance.dart';
import '../../services/maintenance_dio.dart';
import '../../widgets/user_imagepicker.dart';

class FormUploadMaintenance extends StatefulWidget {
  const FormUploadMaintenance({
    Key? key,
    required this.idaction,
  }) : super(key: key);
  final int idaction;

  @override
  State<FormUploadMaintenance> createState() => _FormUploadMaintenanceState();
}

class _FormUploadMaintenanceState extends State<FormUploadMaintenance> {
  final dokumentlist = <String>[
    'Before Unit',
    'Kegiatan Pengerjaan',
    'After Unit',
    'Service Report',
    'Checklist',
    'Dokumen Lainnya'
  ];
  String _dokumen = 'Before Unit';
  File? _userImageFile;
  String filename = '';
  bool isLoading = false;
  int? userid;

  List<Dokumenmaintenance> _listdokumen = [];

  void _pickedImage(File image) {
    _userImageFile = image;
  }

  setter() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      userid = prefs.getInt('userid');
    });
  }

  uploadgambar() {
    MaintenanceDio()
        .uploadfoto(_userImageFile!, widget.idaction, _dokumen)
        .then((value) => filename = value);
    setState(() {});
  }

  void refreshData() {
    setState(() {
      isLoading = true;
    });

    MaintenanceDio().listdokumen(widget.idaction).then((value) {
      setState(() {
        _listdokumen = value;
        isLoading = false;
      });
    });
  }

  @override
  void initState() {
    super.initState();
    refreshData();
    setter();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Container(
          margin: const EdgeInsets.all(15),
          padding: const EdgeInsets.all(5),
          decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(10),
              color: const Color.fromARGB(255, 227, 230, 227)),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Text('id Action : ${widget.idaction}'),
              const SizedBox(height: 5),
              const Text('Foto Gambar'),
              DropdownButton(
                value: _dokumen,
                items: dokumentlist
                    .map((e) => DropdownMenuItem(
                          value: e,
                          child: Text(e),
                        ))
                    .toList(),
                onChanged: (String? val) {
                  setState(() {
                    if (val != null) {
                      _dokumen = val;
                    }
                  });
                },
              ),
              const SizedBox(height: 5),
              UserImagePicker(imagePickFn: _pickedImage),
              ElevatedButton(
                  onPressed: () async {
                    uploadgambar();
                    ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(content: Text('Upload  Success')));
                  },
                  child: const Text('Upload')),
              TextButton.icon(
                  onPressed: () {
                    refreshData();
                  },
                  icon: const Icon(Icons.refresh),
                  label: const Text('Refresh')),
              _listdokumen.isEmpty
                  ? const Text('Gambar belum diupload')
                  : SizedBox(
                      height: 100,
                      child: ListView.builder(
                          scrollDirection: Axis.horizontal,
                          itemCount: _listdokumen.length,
                          itemBuilder: (context, index) {
                            return Container(
                              margin: const EdgeInsets.all(5),
                              child: Card(
                                  child: Image.network(
                                'https://satriapirantiperkasa.com/assets/inventory/${_listdokumen[index].filename}',
                              )),
                            );
                          }),
                    ),
              ElevatedButton(
                  onPressed: () {
                    Navigator.push(context,
                        MaterialPageRoute(builder: (context) {
                      return DashboardPage(
                        userid: userid!,
                      );
                    }));
                  },
                  child: const Text('Selesai'))
            ],
          ),
        ),
      ),
    );
  }
}
