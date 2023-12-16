import 'dart:io';

import 'package:dio/dio.dart';
import 'package:sppscorecard_app/models/dokumentrouble.dart';
import 'package:sppscorecard_app/models/trouble.dart';

class TroubleDio {
  late Dio dio;
  final String baseUrl = "http://192.168.56.1:8000/api";
  TroubleDio() {
    dio = Dio();
  }

  Future<List<Trouble>> listoftrouble(String idsitename) async {
    try {
      final result = await dio.get('$baseUrl/listoftrouble/$idsitename');
      return (result.data as List)
          .map((e) => Trouble.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }

  Future<List<Trouble>> gettrouble(int id) async {
    try {
      final result = await dio.get('$baseUrl/gettrouble/$id');
      return (result.data as List)
          .map((e) => Trouble.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }

  Future postData(Map<String, dynamic> item) async {
    try {
      final result = await dio.post("$baseUrl/trouble/store", data: item);
      return result.data;
    } catch (e) {
      throw Exception(e);
    }
  }

  Future uploadfoto(File file, int idaction, String keterangan) async {
    String fileName = file.path.split('/').last;
    String namafile = "";
    FormData formData = FormData.fromMap({
      "image": await MultipartFile.fromFile(
        file.path,
        filename: fileName,
      ),
      "idaction": idaction,
      "keterangan": keterangan,
      "transaksi": "trouble"
    });
    try {
      await dio
          .post(
            "$baseUrl/apimedia",
            data: formData,
          )
          .then((value) => namafile = value.data);

      return namafile;
    } catch (e) {
      throw Exception(e);
    }
  }

  Future<List<Dokumentrouble>> listdokumen(int idaction) async {
    try {
      final result = await dio.get('$baseUrl/trouble/listdokumen/$idaction');
      return (result.data as List)
          .map((e) => Dokumentrouble.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }
}
