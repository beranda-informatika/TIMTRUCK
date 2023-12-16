import 'package:dio/dio.dart';

class NetworkManager {
  late Dio dio;
  final String baseUrl = "http://192.168.56.1:8000/api";
  //final String baseUrl = "http://192.168.200.252:8000/api";
  NetworkManager() {
    dio = Dio();
  }

  Future login(String email, String password) async {
    try {
      final result = await dio.post(
        '$baseUrl/login',
        data: {
          "email": email,
          "password": password,
        },
      );
      return result.data;
    } catch (e) {
      throw Exception("Exception occured: $e");
    }
  }
}
