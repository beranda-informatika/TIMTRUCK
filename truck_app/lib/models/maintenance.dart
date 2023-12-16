import 'dart:convert';

// ignore_for_file: public_member_api_docs, sort_constructors_first
class Maintenance {
  final int? id;
  final int iduser;
  final String kdunit;
  final String tanggalmulai;
  final String tanggalakhir;
  final String shift;
  final String? actionplan;
  final String? sparepart;
  final int? hm;
  final String? statusmekanik;
  Maintenance({
    this.id,
    required this.iduser,
    required this.kdunit,
    required this.tanggalmulai,
    required this.tanggalakhir,
    required this.shift,
    this.actionplan,
    this.sparepart,
    this.hm,
    this.statusmekanik,
  });

  Map<String, dynamic> toMap() {
    return <String, dynamic>{
      'id': id,
      'iduser': iduser,
      'kdunit': kdunit,
      'tanggalmulai': tanggalmulai,
      'tanggalakhir': tanggalakhir,
      'shift': shift,
      'actionplan': actionplan,
      'sparepart': sparepart,
      'hm': hm,
      'statusmekanik': statusmekanik,
    };
  }

  factory Maintenance.fromMap(Map<String, dynamic> map) {
    return Maintenance(
      id: map['id'] != null ? map['id'] as int : null,
      iduser: map['iduser'] as int,
      kdunit: map['kdunit'] as String,
      tanggalmulai: map['tanggalmulai'] as String,
      tanggalakhir: map['tanggalakhir'] as String,
      shift: map['shift'] as String,
      actionplan:
          map['actionplan'] != null ? map['actionplan'] as String : null,
      sparepart: map['sparepart'] != null ? map['sparepart'] as String : null,
      hm: map['hm'] != null ? map['hm'] as int : null,
      statusmekanik:
          map['statusmekanik'] != null ? map['statusmekanik'] as String : null,
    );
  }

  String toJson() => json.encode(toMap());

  factory Maintenance.fromJson(String source) =>
      Maintenance.fromMap(json.decode(source) as Map<String, dynamic>);
}
