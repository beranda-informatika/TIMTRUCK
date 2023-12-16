import 'dart:convert';

// ignore_for_file: public_member_api_docs, sort_constructors_first
class Sparepart {
  final String codepart;
  final String? partname;
  final String simplename;
  final String partno;
  Sparepart({
    required this.codepart,
    required this.partname,
    required this.simplename,
    required this.partno,
  });

  Map<String, dynamic> toMap() {
    return <String, dynamic>{
      'codepart': codepart,
      'partname': partname,
      'simplename': simplename,
      'partno': partno,
    };
  }

  factory Sparepart.fromMap(Map<String, dynamic> map) {
    return Sparepart(
      codepart: map['codepart'] as String,
      partname: map['partname'] as String,
      simplename: map['simplename'] as String,
      partno: map['partno'] as String,
    );
  }

  String toJson() => json.encode(toMap());

  factory Sparepart.fromJson(String source) =>
      Sparepart.fromMap(json.decode(source) as Map<String, dynamic>);
}
