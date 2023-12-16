import 'package:flutter/material.dart';
import 'package:camera/camera.dart';
import 'dart:io';

import 'package:gallery_saver/gallery_saver.dart';

class CapturePage extends StatefulWidget {
  const CapturePage({super.key});

  @override
  State<CapturePage> createState() => _CapturePageState();
}

class _CapturePageState extends State<CapturePage> {
  List<CameraDescription>? cameras; //list out the camera available
  CameraController? controller; //controller for camera
  XFile? image; //for captured image

  @override
  void initState() {
    loadCamera();
    super.initState();
  }

  loadCamera() async {
    cameras = await availableCameras();
    if (cameras != null) {
      controller = CameraController(cameras![0], ResolutionPreset.max);
      //cameras[0] = first camera, change to 1 to another camera

      controller!.initialize().then((_) {
        if (!mounted) {
          return;
        }
        setState(() {});
      });
    } else {}
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Capture Image from Camera"),
        backgroundColor: Colors.redAccent,
      ),
      body: Container(
          padding: const EdgeInsets.all(2),
          child: Column(children: [
            Center(
              child: Container(
                  height: 300,
                  width: 200,
                  margin: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                      border: Border.all(color: Colors.redAccent, width: 3)),
                  child: controller == null
                      ? const Center(child: Text("Loading Camera..."))
                      : !controller!.value.isInitialized
                          ? const Center(
                              child: CircularProgressIndicator(),
                            )
                          : CameraPreview(controller!)),
            ),
            ElevatedButton.icon(
              //image capture button
              onPressed: () async {
                try {
                  if (controller != null) {
                    //check if contrller is not null
                    if (controller!.value.isInitialized) {
                      //check if controller is initialized
                      image = await controller!.takePicture(); //capture image
                      setState(() {
                        //update UI
                      });
                    }
                  }
                } catch (e) {
                  (e);
                }
              },
              icon: const Icon(Icons.camera),
              label: const Text("Capture"),
            ),
            Center(
              child: Container(
                //show captured image
                padding: const EdgeInsets.all(30),
                child: Column(
                  children: [
                    image == null
                        ? const Text("No image captured")
                        : Image.file(
                            File(image!.path),
                            height: 200,
                          ),
                    ElevatedButton(
                      onPressed: () {
                        //save image to gallery
                        if (image != null) {
                          GallerySaver.saveImage(image!.path);
                          Navigator.pop(
                              context); //back to previous page (camera page
                        }
                      },
                      child: const Text("Save Image"),
                    ),
                  ],
                ),

                //display captured image
              ),
            ),
          ])),
    );
  }
}
