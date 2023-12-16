import 'dart:convert';

// ignore_for_file: public_member_api_docs, sort_constructors_first
class ItemOrder {
  final String codepart;
  final String partname;
  final int partqty;
  ItemOrder({
    required this.codepart,
    required this.partname,
    required this.partqty,
  });



  Map<String, dynamic> toMap() {
    return <String, dynamic>{
      'codepart': codepart,
      'partname': partname,
      'partqty': partqty,
    };
  }

  factory ItemOrder.fromMap(Map<String, dynamic> map) {
    return ItemOrder(
      codepart: map['codepart'] as String,
      partname: map['partname'] as String,
      partqty: map['partqty'] as int,
    );
  }

  String toJson() => json.encode(toMap());

  factory ItemOrder.fromJson(String source) => ItemOrder.fromMap(json.decode(source) as Map<String, dynamic>);
}
