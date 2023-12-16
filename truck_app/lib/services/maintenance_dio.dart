import 'dart:io';

import 'package:dio/dio.dart';
import 'package:sppscorecard_app/models/trouble.dart';

import '../models/dokumenmaintenance.dart';
import '../models/unit.dart';

class MaintenanceDio {
  late Dio dio;
  final String baseUrl = "http://192.168.56.1:8000/api";
  MaintenanceDio() {
    dio = Dio();
  }
  Future<List<Unit>> listofunit(String idsitename) async {
    try {
      final result = await dio.get('$baseUrl/listofunit/$idsitename');
      return (result.data as List)
          .map((e) => Unit.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }

  Future<List<Unit>> getunit(String kdunit) async {
    try {
      final result = await dio.get('$baseUrl/getunit/$kdunit');

      return (result.data as List)
          .map((e) => Unit.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }

  Future<List<Trouble>> listoftrouble(int idsitename) async {
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
      final result = await dio.post("$baseUrl/maintenance/store", data: item);
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
      "transaksi": "maintenance"
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

  Future<List<Dokumenmaintenance>> listdokumen(int idaction) async {
    try {
      final result =
          await dio.get('$baseUrl/maintenance/listdokumen/$idaction');
      return (result.data as List)
          .map((e) => Dokumenmaintenance.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }
}
