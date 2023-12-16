import 'dart:convert';

// ignore_for_file: public_member_api_docs, sort_constructors_first
class Trouble {
  final int? id;
  final String namacbu;
  final String namaregion;
  final String namasitename;
  final String kdunit;
  final String tanggal;
  final String issue;
  final String? documentation;
  final String? targetcompletedate;
  final String? actionplanspp;
  final String? actualcompletedate;
  final int? lapsetime;
  final String? confirmationplan;
  final String? statusspp;
  final String? statuscustomer;
  final String? statusmekanik;
  Trouble({
    this.id,
    required this.namacbu,
    required this.namaregion,
    required this.namasitename,
    required this.kdunit,
    required this.tanggal,
    required this.issue,
    this.documentation,
    this.targetcompletedate,
    this.actionplanspp,
    this.actualcompletedate,
    this.lapsetime,
    this.confirmationplan,
    this.statusspp,
    this.statuscustomer,
    this.statusmekanik,
  });

  Map<String, dynamic> toMap() {
    return <String, dynamic>{
      'id': id,
      'namacbu': namacbu,
      'namaregion': namaregion,
      'namasitename': namasitename,
      'kdunit': kdunit,
      'tanggal': tanggal,
      'issue': issue,
      'documentation': documentation,
      'targetcompletedate': targetcompletedate,
      'actionplanspp': actionplanspp,
      'actualcompletedate': actualcompletedate,
      'lapsetime': lapsetime,
      'confirmationplan': confirmationplan,
      'statusspp': statusspp,
      'statuscustomer': statuscustomer,
      'statusmekanik': statusmekanik,
    };
  }

  factory Trouble.fromMap(Map<String, dynamic> map) {
    return Trouble(
      id: map['id'] != null ? map['id'] as int : null,
      namacbu: map['namacbu'] as String,
      namaregion: map['namaregion'] as String,
      namasitename: map['namasitename'] as String,
      kdunit: map['kdunit'] as String,
      tanggal: map['tanggal'] as String,
      issue: map['issue'] as String,
      documentation:
          map['documentation'] != null ? map['documentation'] as String : null,
      targetcompletedate: map['targetcompletedate'] != null
          ? map['targetcompletedate'] as String
          : null,
      actionplanspp:
          map['actionplanspp'] != null ? map['actionplanspp'] as String : null,
      actualcompletedate: map['actualcompletedate'] != null
          ? map['actualcompletedate'] as String
          : null,
      lapsetime: map['lapsetime'] != null ? map['lapsetime'] as int : null,
      confirmationplan: map['confirmationplan'] != null
          ? map['confirmationplan'] as String
          : null,
      statusspp: map['statusspp'] != null ? map['statusspp'] as String : null,
      statuscustomer: map['statuscustomer'] != null
          ? map['statuscustomer'] as String
          : null,
      statusmekanik:
          map['statusmekanik'] != null ? map['statusmekanik'] as String : null,
    );
  }

  String toJson() => json.encode(toMap());

  factory Trouble.fromJson(String source) =>
      Trouble.fromMap(json.decode(source) as Map<String, dynamic>);
}
