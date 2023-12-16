import 'package:shared_preferences/shared_preferences.dart';

class SharedBio {
  static saveStr(String key, String message) async {
    final SharedPreferences pref = await SharedPreferences.getInstance();
    pref.setString(key, message);
  }

  static saveInt(String key, int message) async {
    final SharedPreferences pref = await SharedPreferences.getInstance();
    pref.setInt(key, message);
  }

  static saveDouble(String key, double message) async {
    final SharedPreferences pref = await SharedPreferences.getInstance();
    pref.setDouble(key, message);
  }

  static readPrefStr(String key) async {
    final SharedPreferences pref = await SharedPreferences.getInstance();
    return pref.getString(key);
  }

  static readPrefInt(String key) async {
    final SharedPreferences pref = await SharedPreferences.getInstance();
    return pref.getInt(key);
  }

  static readPrefDouble(String key) async {
    final SharedPreferences pref = await SharedPreferences.getInstance();
    return pref.getDouble(key);
  }
}
