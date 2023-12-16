import 'dart:convert';

// ignore_for_file: public_member_api_docs, sort_constructors_first
class ProfilModel {
  final int iduser;
  final String namauser;
  final String idcbu;
  final String idregion;
  final int idsitename;
  final String namacbu;
  final String namaregion;
  final String namasitename;
  ProfilModel({
    required this.iduser,
    required this.namauser,
    required this.idcbu,
    required this.idregion,
    required this.idsitename,
    required this.namacbu,
    required this.namaregion,
    required this.namasitename,
  });

  Map<String, dynamic> toMap() {
    return <String, dynamic>{
      'iduser': iduser,
      'namauser': namauser,
      'idcbu': idcbu,
      'idregion': idregion,
      'idsitename': idsitename,
      'namacbu': namacbu,
      'namaregion': namaregion,
      'namasitename': namasitename,
    };
  }

  factory ProfilModel.fromMap(Map<String, dynamic> map) {
    return ProfilModel(
      iduser: map['iduser'] as int,
      namauser: map['namauser'] as String,
      idcbu: map['idcbu'] as String,
      idregion: map['idregion'] as String,
      idsitename: map['idsitename'] as int,
      namacbu: map['namacbu'] as String,
      namaregion: map['namaregion'] as String,
      namasitename: map['namasitename'] as String,
    );
  }

  String toJson() => json.encode(toMap());

  factory ProfilModel.fromJson(String source) =>
      ProfilModel.fromMap(json.decode(source) as Map<String, dynamic>);
}
