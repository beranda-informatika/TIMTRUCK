import 'package:dio/dio.dart';
import 'package:sppscorecard_app/models/shipment.dart';

class ShipmentDio {
  late Dio dio;
  final String baseUrl = "http://192.168.56.1:8000/api";
  ShipmentDio() {
    dio = Dio();
  }

  Future<List<ShipmentModel>> listshipment(String kddriver) async {
    try {
      final result = await dio.get('$baseUrl/listshipment/$kddriver');
      return (result.data as List)
          .map((e) => ShipmentModel.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }

  Future<List<ShipmentModel>> listhistoryshipment(String kddriver) async {
    try {
      final result = await dio.get('$baseUrl/listhistoryshipment/$kddriver');
      return (result.data as List)
          .map((e) => ShipmentModel.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }

  Future<List<ShipmentModel>> getshoment(String shipmentid) async {
    try {
      final result = await dio.get('$baseUrl/getshipment/$shipmentid');

      return (result.data as List)
          .map((e) => ShipmentModel.fromMap(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }
}
