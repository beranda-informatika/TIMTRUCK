// ignore_for_file: public_member_api_docs, sort_constructors_first

import "package:flutter/material.dart";
import "package:sppscorecard_app/models/shipment.dart";
import 'package:sppscorecard_app/pages/driver/shipmentdetailpage.dart';
import "package:intl/intl.dart";
import "package:shared_preferences/shared_preferences.dart";
import "package:sppscorecard_app/services/shipment_dio.dart";

import "login.dart";

class DashboardPage extends StatefulWidget {
  const DashboardPage({
    Key? key,
    required this.userid,
  }) : super(key: key);
  final int userid;

  @override
  State<DashboardPage> createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  late SharedPreferences prefs;
  Future<void> loadPrefs() async {
    prefs = await SharedPreferences.getInstance();
  }

  var f = NumberFormat("#,###", "id_ID");
  int selectedindex = 0;
  int pageIndex = 0;
  int pageIndexadds = 0;
  String? username = "";
  String? kddriver = "";

  int? userid;
  bool isAds = false;
  bool isNews = false;

  bool isLoading = false;
  int addsCount = 1;
  int newsCount = 1;
  final List<ShipmentModel> shipment = [];

  Map<String, dynamic> _profil = <String, dynamic>{};

  setter() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    Future.delayed(const Duration(seconds: 1), () {
      setState(() {
        username = prefs.getString('username');
        userid = prefs.getInt('userid');
        kddriver = prefs.getString('kddriver');
        _profil = {
          'iduser': prefs.getInt('userid')!,
          'namauser': prefs.getString('username')!,
          'kddriver': prefs.getString('kddriver')!,
        };
      });
    });
  }

  void refreshData() {
    ShipmentDio().listshipment(kddriver!).then((value) {
      setState(() {
        shipment.clear();
        shipment.addAll(value);
      });
    });
    setState(() {
      isLoading = false;
    });
  }

  void historyshipment() {
    ShipmentDio().listhistoryshipment(kddriver!).then((value) {
      setState(() {
        shipment.clear();
        shipment.addAll(value);
      });
    });
    setState(() {
      isLoading = false;
    });
  }

  @override
  void initState() {
    super.initState();
    setter();
  }

  void _logout() async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    await preferences.clear();
    if (!mounted) return;
    Navigator.pushReplacement(context, MaterialPageRoute(builder: (context) {
      return const LoginPage();
    }));
  }

  void _ontap(int index) {
    if (index == 0) {
      Navigator.push(context, MaterialPageRoute(builder: (context) {
        return DashboardPage(userid: widget.userid);
      }));
    } else if (index == 1) {
      refreshData();
    } else if (index == 2) {
      historyshipment();
    } else if (index == 3) {
      _logout();
    }
    setState(() {
      selectedindex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return WillPopScope(
      onWillPop: () async => false,
      child: Container(
        decoration: const BoxDecoration(
          image: DecorationImage(
            image: AssetImage("assets/images/background.png"),
            fit: BoxFit.cover,
          ),
        ),
        child: Scaffold(
          backgroundColor: Colors.transparent,
          body: SingleChildScrollView(
            child: Padding(
              padding: const EdgeInsets.all(8.0),
              child: Column(
                children: [
                  Column(
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: [
                        Column(
                          children: [
                            Container(
                              margin: const EdgeInsets.only(top: 20),
                              height: 140,
                              width: 220,
                              child: Column(
                                children: [
                                  const SizedBox(height: 10),
                                  CircleAvatar(
                                    backgroundColor: Colors.white,
                                    radius: 50,
                                    child: Image.asset('assets/images/logo.png',
                                        width: 100, height: 100),
                                  ),
                                  const SizedBox(height: 15),
                                ],
                              ),
                            ),
                            Card(
                              margin: const EdgeInsets.all(20),
                              color: const Color.fromARGB(255, 215, 252, 6),
                              child: ListTile(
                                leading: const Icon(
                                  Icons.person,
                                  color: Color.fromARGB(255, 99, 97, 97),
                                  size: 40,
                                ),
                                title: const Text(
                                  "Selamat Datang",
                                  style: TextStyle(
                                    fontSize: 15,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                subtitle: Text(
                                  username! + " - " + kddriver!,
                                  style: const TextStyle(
                                    fontSize: 15,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                              ),
                            ),
                          ],
                        ),
                        const SizedBox(height: 10),
                        shipment.isEmpty
                            ? const Center(child: Text("Tidak ada data"))
                            : ListView.builder(
                                shrinkWrap: true,
                                physics: const NeverScrollableScrollPhysics(),
                                itemCount: shipment.length,
                                itemBuilder: (context, index) {
                                  return Card(
                                    child: ListTile(
                                      title: Text(
                                          "${shipment[index].origin} - ${shipment[index].destination}"),
                                      subtitle: Text(
                                        "Tgl. Shipment : ${shipment[index].tglshipment} - Status : ${shipment[index].f_status} - Unit : ${shipment[index].kdunit} - Driver : ${shipment[index].kddriver}",
                                        style: const TextStyle(
                                          fontSize: 12,
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                      trailing: IconButton(
                                        onPressed: () {
                                          Navigator.push(context,
                                              MaterialPageRoute(
                                                  builder: (context) {
                                            return ShipmentDetailPage(
                                                shipmentid:
                                                    shipment[index].shipmentid,
                                                shipmentmodel: shipment[index]);
                                          }));
                                        },
                                        icon:
                                            const Icon(Icons.arrow_forward_ios),
                                      ),
                                      isThreeLine: true,
                                    ),
                                  );
                                },
                              ),

                        // ignore: prefer_const_constructors
                      ]),
                  const SizedBox(
                    height: 50,
                  )
                ],
              ),
            ),
          ),
          bottomNavigationBar: BottomNavigationBar(
            type: BottomNavigationBarType.fixed,
            selectedItemColor: const Color.fromARGB(255, 4, 163, 226),
            iconSize: 20,
            currentIndex: selectedindex,
            onTap: _ontap,
            items: const [
              BottomNavigationBarItem(
                icon: Icon(Icons.home),
                label: 'Home',
              ),
              BottomNavigationBarItem(
                icon: Icon(Icons.fire_truck),
                label: 'Planning',
              ),
              BottomNavigationBarItem(
                icon: Icon(Icons.history),
                label: 'History',
              ),
              BottomNavigationBarItem(
                icon: Icon(Icons.logout_outlined),
                label: 'Logout',
              ),
            ],
          ),
        ),
      ),
    );
  }
}
