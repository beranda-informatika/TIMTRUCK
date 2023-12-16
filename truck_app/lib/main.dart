import 'package:flutter/material.dart';
import 'package:sppscorecard_app/pages/dashboard_page.dart';
import 'package:sppscorecard_app/pages/splashscreen.dart';
import 'package:shared_preferences/shared_preferences.dart';

void main() => runApp(const MyApp());

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: SharedPreferences.getInstance(),
      builder: (BuildContext context, AsyncSnapshot<SharedPreferences> prefs) {
        //var x = prefs.data;
        if (prefs.hasData) {
          if (prefs.data!.getInt('userid') != null) {
            var xuserid = prefs.data!.getInt('userid')!;
            var xrolesid = prefs.data!.getInt('rolesid')!;

            if (xrolesid == 3) {
              return MaterialApp(
                  debugShowCheckedModeBanner: false,
                  home: DashboardPage(
                    userid: xuserid,
                  ));
            } else {
              return const MaterialApp(home: SplashScreenPage());
            }
          } else {
            return const MaterialApp(home: SplashScreenPage());
          }
        } else {
          return const MaterialApp(home: SplashScreenPage());
        }
      },
    );
  }
}
