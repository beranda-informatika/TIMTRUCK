import 'dart:convert';

// ignore_for_file: public_member_api_docs, sort_constructors_first

class Wilayah {
  final String idwil;
  final String nmwil;
  Wilayah({
    required this.idwil,
    required this.nmwil,
  });

  Map<String, dynamic> toMap() {
    return <String, dynamic>{
      'idwil': idwil,
      'nmwil': nmwil,
    };
  }

  factory Wilayah.fromMap(Map<String, dynamic> map) {
    return Wilayah(
      idwil: map['idwil'] as String,
      nmwil: map['nmwil'] as String,
    );
  }

  String toJson() => json.encode(toMap());

  factory Wilayah.fromJson(String source) =>
      Wilayah.fromMap(json.decode(source) as Map<String, dynamic>);

  Wilayah copyWith({
    String? idwil,
    String? nmwil,
  }) {
    return Wilayah(
      idwil: idwil ?? this.idwil,
      nmwil: nmwil ?? this.nmwil,
    );
  }

  @override
  String toString() => 'Wilayah(idwil: $idwil, nmwil: $nmwil)';
}
