import 'dart:convert';

// ignore_for_file: public_member_api_docs, sort_constructors_first
class Unit {
  final String kdunit;
  final String serialnumber;
  final String namaunit;
  final String idsitename;
  final int hm;

  Unit({
    required this.kdunit,
    required this.serialnumber,
    required this.namaunit,
    required this.idsitename,
    required this.hm,
  });

  Map<String, dynamic> toMap() {
    return <String, dynamic>{
      'kdunit': kdunit,
      'serialnumber': serialnumber,
      'namaunit': namaunit,
      'idsitename': idsitename,
      'hm': hm,
    };
  }

  factory Unit.fromMap(Map<String, dynamic> map) {
    return Unit(
      kdunit: map['kdunit'] as String,
      serialnumber: map['serialnumber'] as String,
      namaunit: map['namaunit'] as String,
      idsitename: map['idsitename'] as String,
      hm: map['hm'] as int,
    );
  }

  String toJson() => json.encode(toMap());

  factory Unit.fromJson(String source) =>
      Unit.fromMap(json.decode(source) as Map<String, dynamic>);
}
