// ignore_for_file: public_member_api_docs, sort_constructors_first
import 'dart:io';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

class UserImagePicker extends StatefulWidget {
  final void Function(File pickedImage) imagePickFn;
  const UserImagePicker({
    Key? key,
    required this.imagePickFn,
  }) : super(key: key);

  @override
  State<UserImagePicker> createState() => _UserImagePickerState();
}

class _UserImagePickerState extends State<UserImagePicker> {
  File? _pickedImage;
  final List<String> _dropdownValues = [
    'Ambil Gambar',
    'Camera',
    'Gallery',
  ];
  String selected = 'Ambil Gambar';
  void _pickImage() async {
    final pickedImageFile = await ImagePicker().pickImage(
      source: selected == 'Gallery' ? ImageSource.gallery : ImageSource.camera,
      imageQuality: 75,
      //maxWidth: 600,
    );
    setState(() {
      _pickedImage = File(pickedImageFile!.path);
    });
    widget.imagePickFn(_pickedImage!);
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        _pickedImage != null
            ? Image.file(
                _pickedImage!,
                width: 80,
                height: 80,
                fit: BoxFit.cover,
              )
            : Image.asset(
                'assets/images/nopict.jpeg',
                width: 80,
                height: 80,
                fit: BoxFit.cover,
              ),
        // CircleAvatar(
        //   radius: 40,
        //   backgroundColor: Colors.grey,
        //   backgroundImage:
        //       _pickedImage != null ? FileImage(_pickedImage!) : null,
        // ),
        DropdownButton(
          icon: const Icon(Icons.camera_alt_rounded),
          value: selected,
          hint: const Text('Pilih Sumber Gambar'),
          items: _dropdownValues
              .map((e) => DropdownMenuItem(value: e, child: Text(e)))
              .toList(),
          onChanged: (value) {
            setState(() {
              selected = value.toString();
              _pickImage();
            });
          },
        ),
      ],
    );
  }
}
