// ignore_for_file: public_member_api_docs, sort_constructors_first
import 'package:flutter/material.dart';

class ProfilWidget extends StatefulWidget {
  const ProfilWidget({
    Key? key,
    required this.profil,
  }) : super(key: key);
  final Map<String, dynamic> profil;

  @override
  State<ProfilWidget> createState() => _ProfilWidgetState();
}

class _ProfilWidgetState extends State<ProfilWidget> {
  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.only(top: 5),
      height: 130,
      width: 330,
      child: Card(
        margin: const EdgeInsets.only(top: 5, bottom: 5),
        color: const Color.fromARGB(255, 232, 240, 248),
        elevation: 5,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(10),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const SizedBox(height: 10),
            const Padding(
              padding: EdgeInsets.only(left: 8.0),
              child: Text('CBU',
                  textAlign: TextAlign.left,
                  style: TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.bold,
                    color: Color.fromARGB(255, 138, 137, 134),
                  )),
            ),
            Padding(
              padding: const EdgeInsets.only(left: 8.0),
              child: Text(widget.profil['namacbu'],
                  textAlign: TextAlign.left,
                  style: const TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.bold,
                  )),
            ),
            const SizedBox(height: 5),
            const Padding(
              padding: EdgeInsets.only(left: 8.0),
              child: Text('Region',
                  style: TextStyle(
                      fontSize: 12,
                      fontWeight: FontWeight.bold,
                      color: Color.fromARGB(255, 138, 137, 134))),
            ),
            Padding(
              padding: const EdgeInsets.only(left: 8.0),
              child: Text(widget.profil['namaregion'],
                  textAlign: TextAlign.left,
                  style: const TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.bold,
                  )),
            ),
            const SizedBox(height: 5),
            const Padding(
              padding: EdgeInsets.only(left: 8.0),
              child: Text('Site Name',
                  style: TextStyle(
                      fontSize: 12,
                      fontWeight: FontWeight.bold,
                      color: Color.fromARGB(255, 138, 137, 134))),
            ),
            Padding(
              padding: const EdgeInsets.only(left: 8.0),
              child: Text(widget.profil['namasitename'],
                  textAlign: TextAlign.left,
                  style: const TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.bold,
                  )),
            )
          ],
        ),
      ),
    );
  }
}
