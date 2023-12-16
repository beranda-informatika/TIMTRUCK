// ignore_for_file: public_member_api_docs, sort_constructors_first
import 'dart:convert';

class Dokumentrouble {
  final int? id;
  final int idaction;
  final String keterangan;
  final String filename;
  Dokumentrouble({
    this.id,
    required this.idaction,
    required this.keterangan,
    required this.filename,
  });

  Map<String, dynamic> toMap() {
    return <String, dynamic>{
      'id': id,
      'idaction': idaction,
      'keterangan': keterangan,
      'filename': filename,
    };
  }

  factory Dokumentrouble.fromMap(Map<String, dynamic> map) {
    return Dokumentrouble(
      id: map['id'] != null ? map['id'] as int : null,
      idaction: map['idaction'] as int,
      keterangan: map['keterangan'] as String,
      filename: map['filename'] as String,
    );
  }

  String toJson() => json.encode(toMap());

  factory Dokumentrouble.fromJson(String source) =>
      Dokumentrouble.fromMap(json.decode(source) as Map<String, dynamic>);
}
