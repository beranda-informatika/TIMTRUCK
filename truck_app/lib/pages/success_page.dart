// ignore_for_file: public_member_api_docs, sort_constructors_first
import 'package:flutter/material.dart';

import 'package:sppscorecard_app/pages/dashboard_page.dart';

class SuccessPage extends StatefulWidget {
  const SuccessPage({
    Key? key,
    this.userid,
  }) : super(key: key);
  final int? userid;

  @override
  State<SuccessPage> createState() => _SuccessPageState();
}

class _SuccessPageState extends State<SuccessPage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body: Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Image.asset('assets/images/logo.png'),
          const SizedBox(height: 20),
          const Text('Transaksi Berhasil', style: TextStyle(fontSize: 20)),
          const SizedBox(height: 5),
          const Text('untuk cek status order silahkan klik icon order'),
          ElevatedButton(
            onPressed: () {
              Navigator.push(
                  context,
                  MaterialPageRoute(
                      builder: (context) =>
                          DashboardPage(userid: widget.userid!)));
            },
            child: const Text('Selesai'),
          ),
        ],
      ),
    ));
  }
}
