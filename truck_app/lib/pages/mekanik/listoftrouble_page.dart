// ignore_for_file: public_member_api_docs, sort_constructors_first
import "package:flutter/material.dart";
import "package:sppscorecard_app/services/maintenance_dio.dart";

import "../../models/unit.dart";
import "../../widgets/itemtrouble_widget.dart";

class ListOfTroublePage extends StatefulWidget {
  const ListOfTroublePage({
    Key? key,
    required this.profil,
  }) : super(key: key);
  final Map<String, dynamic> profil;

  @override
  State<ListOfTroublePage> createState() => _ListOfTroublePage();
}

class _ListOfTroublePage extends State<ListOfTroublePage> {
  String? nama = "";
  int? userid;
  bool isLoading = false;
  List<Unit> _unit = [];
  String? idsitename = '';
  void refreshData() async {
    setState(() {
      isLoading = true;
    });

    await MaintenanceDio().listofunit(idsitename!).then((value) {
      setState(() {
        _unit = value;
        isLoading = false;
      });
    });
  }

  @override
  void initState() {
    super.initState();
    idsitename = widget.profil['idsitename'];
    refreshData();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Padding(
        padding: const EdgeInsets.all(8.0),
        child: Column(
          children: [
            const SizedBox(
              height: 30,
            ),
            Container(
              alignment: Alignment.center,
              height: 50,
              color: Colors.orange,
              width: double.infinity,
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  IconButton(
                    onPressed: () {
                      Navigator.pop(context);
                    },
                    icon: const Icon(Icons.arrow_back),
                  ),
                  const Text(
                    "List Of Unit",
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  IconButton(
                    onPressed: () {
                      return refreshData();
                    },
                    icon: const Icon(Icons.refresh),
                  ),
                ],
              ),
            ),
            Container(
              height: 70,
              color: Colors.transparent,
              margin: const EdgeInsets.only(top: 10),
              child: Image.asset('assets/images/logo.png',
                  width: 100, height: 100),
            ),
            Container(
              height: 50,
              color: Colors.transparent,
              margin: const EdgeInsets.only(top: 10),
              child: Form(
                child: TextFormField(
                  decoration: const InputDecoration(
                    border: OutlineInputBorder(),
                    labelText: 'Cari Unit',
                  ),
                  onChanged: (value) {
                    setState(() {
                      _unit = _unit
                          .where((element) => element.namaunit
                              .toLowerCase()
                              .contains(value.toLowerCase()))
                          .toList();
                    });
                  },
                ),
              ),
            ),
            isLoading
                ? const Center(
                    child: CircularProgressIndicator(),
                  )
                : Expanded(
                    child: _unit.isEmpty
                        ? const Center(
                            child: Text('Tidak ada Unit'),
                          )
                        : ListView.builder(
                            itemCount: _unit.length,
                            itemBuilder: (context, index) {
                              return ItemTroubleWidget(
                                unit: _unit[index],
                                handleRefresh: refreshData,
                              );
                            }),
                  ),
          ],
        ),
      ),
    );
  }
}
