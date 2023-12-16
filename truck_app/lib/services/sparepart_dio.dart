import 'dart:convert';

import 'package:dio/dio.dart';
import 'package:sppscorecard_app/models/sparepart.dart';

class SparepartDio {
  late Dio dio;
  final String baseUrl = "http://192.168.56.1:8000/api";
  SparepartDio() {
    dio = Dio();
  }

  Future<List<Sparepart>> listoftsparepart(String idsitename) async {
    try {
      final result = await dio.get('$baseUrl/listofsparepart/$idsitename');
      return (result.data as List)
          .map((e) => Sparepart.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }

  Future<List<Sparepart>> searchsparepart(String partname) async {
    try {
      final result = await dio.get('$baseUrl/searchsparepart/$partname');
      return (result.data as List)
          .map((e) => Sparepart.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }

  Future postdata(Map<String, dynamic> itemdetail) async {
    try {
      final dataku = json.encode(itemdetail);
      final result = await dio.post('$baseUrl/sparepart/store', data: dataku);
      return result.data;
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }
}
