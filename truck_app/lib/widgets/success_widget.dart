import 'package:flutter/material.dart';

class WidgetSuccessDialog extends StatelessWidget {
  final String subtitle;
  const WidgetSuccessDialog({
    Key? key,
    required this.subtitle,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title: const Text('Informasi'),
      content: Text(subtitle),
      actions: [
        TextButton(
          onPressed: () {
            Navigator.of(context).pop();
          },
          child: const Text('OK'),
        ),
      ],
    );
  }
}
