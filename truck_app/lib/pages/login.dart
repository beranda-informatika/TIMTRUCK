import 'package:flutter/material.dart';
import 'package:sppscorecard_app/pages/dashboard_page.dart';
import 'package:sppscorecard_app/services/network_manager.dart';
import 'package:shared_preferences/shared_preferences.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final _formKey = GlobalKey<FormState>();
  final _isLogin = true;
  var email = '';
  var password = '';
  var username = '';
  var kddriver = '';

  int? rolesid;
  int userid = 0;

  bool status = false;

  void _setter() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.setString('username', username);
    await prefs.setString('nama', username);
    await prefs.setString('email', email);
    await prefs.setInt('rolesid', rolesid!);
    await prefs.setInt('userid', userid);
    await prefs.setString('kddriver', kddriver);
  }

  bool xobscureText = true;
  void xtoggle() {
    setState(() {
      xobscureText = !xobscureText;
    });
  }

  @override
  Widget build(BuildContext context) {
    return WillPopScope(
      onWillPop: () async => false,
      child: Scaffold(
          backgroundColor: const Color.fromARGB(255, 253, 185, 58),
          body: Center(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Container(
                  padding: const EdgeInsets.all(16),
                  child: Card(
                      child: Padding(
                    padding: const EdgeInsets.all(16),
                    child: Form(
                        key: _formKey,
                        child: Column(
                          children: [
                            Container(
                              width: 120,
                              height: 100,
                              decoration: const BoxDecoration(
                                image: DecorationImage(
                                  image: AssetImage('assets/images/logo.png'),
                                  fit: BoxFit.fill,
                                ),
                                shape: BoxShape.rectangle,
                              ),
                            ),
                            const SizedBox(height: 12),
                            const Text(
                              'Masuk',
                              style: TextStyle(fontSize: 20),
                              textAlign: TextAlign.left,
                            ),
                            const SizedBox(height: 12),
                            const Text(
                                'Hi ! Senang Bertemu Lagi Denganmu Lagi'),
                            TextFormField(
                              key: const ValueKey('email'),
                              validator: (value) {
                                if (value!.isEmpty || !value.contains('@')) {
                                  return 'Please enter a valid email address.';
                                }
                                return null;
                              },
                              keyboardType: TextInputType.emailAddress,
                              decoration: const InputDecoration(
                                  labelText: 'Email address'),
                              onSaved: (value) {
                                email = value!;
                              },
                            ),
                            TextFormField(
                              key: const ValueKey('password'),
                              validator: (value) {
                                if (value!.isEmpty || value.length < 2) {
                                  return 'Password must be at least 7 characters long.';
                                }
                                return null;
                              },
                              decoration: InputDecoration(
                                labelText: 'Password',
                                suffixIcon: IconButton(
                                  icon: Icon(
                                    xobscureText
                                        ? Icons.visibility
                                        : Icons.visibility_off,
                                  ),
                                  onPressed: xtoggle,
                                ),
                              ),
                              obscureText: xobscureText,
                              onSaved: (value) {
                                password = value!;
                              },
                            ),
                            const SizedBox(height: 12),
                            ElevatedButton(
                              onPressed: () async {
                                final isValid =
                                    _formKey.currentState!.validate();
                                FocusScope.of(context).unfocus();

                                if (isValid) {
                                  _formKey.currentState!.save();
                                  await NetworkManager()
                                      .login(email, password)
                                      .then((value) => {
                                            if (value["status"] == true)
                                              {
                                                setState(() {
                                                  username = value["username"];
                                                  userid = value["userid"];
                                                  email = value["email"];
                                                  status = value["status"];
                                                  rolesid = value["roles_id"];
                                                  kddriver = value["kddriver"];
                                                }),
                                                _setter(),
                                                if (rolesid == 6)
                                                  {
                                                    Navigator.push(context,
                                                        MaterialPageRoute(
                                                      builder: (context) {
                                                        return DashboardPage(
                                                            userid: userid);
                                                      },
                                                    ))
                                                  }
                                              }
                                            else
                                              {
                                                showDialog(
                                                    context: context,
                                                    builder:
                                                        (BuildContext context) {
                                                      return AlertDialog(
                                                        title: const Text(
                                                            'Informasi'),
                                                        content: const Text(
                                                            'Login Gagal, username atau password salah'),
                                                        actions: [
                                                          TextButton(
                                                              onPressed: () {
                                                                Navigator.of(
                                                                        context)
                                                                    .pop();
                                                              },
                                                              child: const Text(
                                                                  'OK'))
                                                        ],
                                                      );
                                                    })
                                              }
                                          });

                                  // Use those values to send our auth request ...
                                }
                              },
                              child: Text(_isLogin ? 'Login' : 'Signup'),
                            ),
                          ],
                        )),
                  )),
                ),
              ],
            ),
          )),
    );
  }
}
