// ignore: prefer_const_constructors

import 'package:flutter/material.dart';
import 'package:sppscorecard_app/models/itemorder.dart';
import 'package:sppscorecard_app/models/sparepart.dart';
import 'package:sppscorecard_app/pages/dashboard_page.dart';
import 'package:sppscorecard_app/services/maintenance_dio.dart';
import 'package:sppscorecard_app/services/sparepart_dio.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../models/unit.dart';

class FormSparepartPage extends StatefulWidget {
  const FormSparepartPage({
    Key? key,
    required this.kdunit,
  }) : super(key: key);
  final String kdunit;

  @override
  State<FormSparepartPage> createState() => _FormSparepartPageState();
}

class _FormSparepartPageState extends State<FormSparepartPage> {
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

  final keyword = TextEditingController();
  final _codepart = TextEditingController();
  final _sparepart = TextEditingController();
  final _partqty = TextEditingController();

  List<String> dokumen = [];
  List<ItemOrder> itemorder = [];
  List<Unit> _unit = [];
  List<Sparepart> sparepart = [];
  String status = "";
  String kdunit = '';

  bool isLoading = false;
  FocusNode qtyfocus = FocusNode();
  FocusNode keywordfocus = FocusNode();

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

  Future searchdata(var namasparepart) async {
    await SparepartDio().searchsparepart(namasparepart).then((value) {
      setState(() {
        sparepart = value;
        isLoading = false;
        sparepart.isEmpty
            ? showDialog(
                context: context,
                builder: (BuildContext context) {
                  return const AlertDialog(
                    title: Text('Information'),
                    content: Text('Data tidak ditemukan'),
                  );
                })
            : showDialog(
                context: context,
                builder: (BuildContext context) {
                  return AlertDialog(
                    title: const Text('Pilih Sparepart'),
                    content: SizedBox(
                      width: 300,
                      height: 200,
                      child: ListView.builder(
                        itemCount: sparepart.length,
                        itemBuilder: (context, index) {
                          return ListTile(
                            title: Text(
                                "${sparepart[index].simplename} - ${sparepart[index].partname!}",
                                style: const TextStyle(fontSize: 10)),
                            onTap: () {
                              setState(() {
                                _sparepart.text = sparepart[index].partname!;
                                _codepart.text = sparepart[index].codepart;
                                keyword.clear();
                                Navigator.pop(context);
                                qtyfocus.requestFocus();
                              });
                            },
                          );
                        },
                      ),
                    ),
                  );
                });
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
          title: const Text('Form Sparepart'),
          actions: [
            IconButton(
              onPressed: () {
                Navigator.pop(context);
              },
              icon: IconButton(
                onPressed: () {
                  return refreshData();
                },
                icon: const Icon(Icons.refresh),
              ),
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
                color: const Color.fromARGB(255, 233, 9, 132),
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
            Form(
              child: Container(
                  margin: const EdgeInsets.all(15),
                  decoration:
                      BoxDecoration(borderRadius: BorderRadius.circular(10)),
                  child: Column(
                    children: [
                      const SizedBox(height: 10),
                      TextField(
                          controller: keyword,
                          focusNode: keywordfocus,
                          decoration: InputDecoration(
                            suffixIcon: IconButton(
                              icon: const Icon(Icons.search),
                              onPressed: () async {
                                await Future.delayed(const Duration(seconds: 1),
                                    () {
                                  setState(() {
                                    isLoading = true;
                                    sparepart.clear();
                                    if (keyword.text.isEmpty) {
                                      ScaffoldMessenger.of(context)
                                          .showSnackBar(
                                        const SnackBar(
                                          content: Text(
                                              'Harap isi keyword terlebih dahulu'),
                                        ),
                                      );
                                      return;
                                    }
                                    searchdata(keyword.text);
                                  });
                                });
                              },
                            ),
                          )),
                      const SizedBox(height: 10),
                      TextFormField(
                        enabled: false,
                        controller: _codepart,
                        decoration: const InputDecoration(
                            hintText: 'Code Part',
                            border: OutlineInputBorder(),
                            suffixIcon: Icon(Icons.abc),
                            labelText: 'Code Sparepart'),
                        onTap: () {},
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Code Part tidak boleh kosong';
                          }
                          return null;
                        },
                      ),
                      const SizedBox(height: 10),
                      TextFormField(
                        enabled: false,
                        controller: _sparepart,
                        decoration: const InputDecoration(
                            hintText: 'Name of  Sparepart',
                            border: OutlineInputBorder(),
                            suffixIcon: Icon(Icons.abc),
                            labelText: 'Name of Sparepart'),
                        onTap: () {},
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Order Part tidak boleh kosong';
                          }
                          return null;
                        },
                      ),
                      const SizedBox(height: 10),
                      TextFormField(
                        enabled: true,
                        focusNode: qtyfocus,
                        controller: _partqty,
                        keyboardType: TextInputType.number,
                        decoration: const InputDecoration(
                            hintText: 'Qty',
                            border: OutlineInputBorder(),
                            suffixIcon: Icon(Icons.numbers),
                            labelText: 'Qty'),
                        onTap: () {},
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Qty  tidak boleh kosong';
                          }
                          return null;
                        },
                      ),
                      const SizedBox(height: 10),
                      ElevatedButton(
                          onPressed: () {
                            if (_sparepart.text.isEmpty ||
                                _partqty.text.isEmpty) {
                              ScaffoldMessenger.of(context).showSnackBar(
                                const SnackBar(
                                  content: Text(
                                      'Harap isi semua data terlebih dahulu'),
                                ),
                              );
                              return;
                            } else {
                              setState(() {
                                itemorder.add(ItemOrder(
                                    codepart: _codepart.text,
                                    partname: _sparepart.text,
                                    partqty: int.parse(_partqty.text)));
                                _sparepart.clear();
                                _partqty.clear();
                                _codepart.clear();
                                sparepart.clear();
                                keywordfocus.requestFocus();
                              });
                            }
                          },
                          child: const Text('Tambah Sparepart')),
                      itemorder.isEmpty
                          ? const Text('Belum ada order')
                          : ListView.builder(
                              shrinkWrap: true,
                              itemCount: itemorder.length,
                              itemBuilder: (context, index) {
                                return Container(
                                  margin: const EdgeInsets.all(2),
                                  decoration: const BoxDecoration(
                                      color:
                                          Color.fromARGB(255, 190, 238, 181)),
                                  child: ListTile(
                                    title: Text(itemorder[index].partname),
                                    subtitle: Text(
                                        "Code: ${itemorder[index].codepart} qty: ${itemorder[index].partqty}"),
                                    trailing: IconButton(
                                      onPressed: () {
                                        setState(() {
                                          itemorder.removeAt(index);
                                        });
                                      },
                                      icon: const Icon(
                                        Icons.delete,
                                        color: Colors.red,
                                      ),
                                    ),
                                  ),
                                );
                              },
                            ),
                      itemorder.isEmpty
                          ? const SizedBox(height: 10)
                          : Container(
                              padding: const EdgeInsets.all(5),
                              width: double.infinity,
                              height: 50,
                              decoration: const BoxDecoration(
                                  color: Color.fromARGB(255, 250, 115, 5)),
                              child: Row(
                                mainAxisAlignment:
                                    MainAxisAlignment.spaceBetween,
                                children: [
                                  TextButton.icon(
                                      onPressed: () {
                                        if (itemorder.isEmpty) {
                                          ScaffoldMessenger.of(context)
                                              .showSnackBar(
                                            const SnackBar(
                                              content: Text(
                                                  'Harap isi semua data terlebih dahulu'),
                                            ),
                                          );
                                          return;
                                        }

                                        final Map<String, dynamic> itemdetail =
                                            {
                                          'kdunit': widget.kdunit,
                                          'iduser': userid!,
                                          'idsitename': _unit[0].idsitename,
                                          'itemorder': itemorder
                                              .asMap()
                                              .entries
                                              .map((e) => {
                                                    'partname':
                                                        e.value.partname,
                                                    'partqty': e.value.partqty,
                                                  })
                                              .toList(),
                                        };
                                        setState(() => isLoading = true);
                                        SparepartDio()
                                            .postdata(itemdetail)
                                            .then((value) {
                                          setState(() {
                                            if (value['noorder'] > 0) {
                                              ScaffoldMessenger.of(context)
                                                  .showSnackBar(
                                                const SnackBar(
                                                  content: Text(
                                                      'Data berhasil disimpan'),
                                                ),
                                              );
                                              Future.delayed(
                                                  const Duration(seconds: 3),
                                                  () {
                                                Navigator.push(
                                                    context,
                                                    MaterialPageRoute(
                                                      builder: (context) =>
                                                          DashboardPage(
                                                              userid: userid!),
                                                    ));
                                              });
                                            } else {
                                              ScaffoldMessenger.of(context)
                                                  .showSnackBar(
                                                const SnackBar(
                                                  content: Text(
                                                      'Data gagal disimpan'),
                                                ),
                                              );
                                            }
                                            isLoading = false;
                                          });
                                        });
                                      },
                                      icon: const Icon(
                                        Icons.fast_forward,
                                        color: Colors.white,
                                      ),
                                      label: const Text(
                                        'Submit Order Sparepart',
                                        style: TextStyle(color: Colors.white),
                                      )),
                                ],
                              ),
                            ),
                    ],
                  )),
            ),
          ],
        ),
      ),
    );
  }
}
