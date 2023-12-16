import 'dart:convert';

class ShipmentModel {
  final String shipmentid;
  final String origin;
  final String destination;
  final String f_status;
  final String tglshipment;
  final String kddriver;
  final String kdunit;
  final int ujo;
  ShipmentModel({
    required this.shipmentid,
    required this.origin,
    required this.destination,
    required this.f_status,
    required this.tglshipment,
    required this.kddriver,
    required this.kdunit,
    required this.ujo,
  });

  Map<String, dynamic> toMap() {
    return {
      'shipmentid': shipmentid,
      'origin': origin,
      'destination': destination,
      'f_status': f_status,
      'tglshipment': tglshipment,
      'kddriver': kddriver,
      'kdunit': kdunit,
      'ujo': ujo,
    };
  }

  factory ShipmentModel.fromMap(Map<String, dynamic> map) {
    return ShipmentModel(
      shipmentid: map['shipmentid'] ?? '',
      origin: map['origin'] ?? '',
      destination: map['destination'] ?? '',
      f_status: map['f_status'] ?? '',
      tglshipment: map['tglshipment'] ?? '',
      kddriver: map['kddriver'] ?? '',
      kdunit: map['kdunit'] ?? '',
      ujo: map['ujo']?.toInt() ?? 0,
    );
  }

  String toJson() => json.encode(toMap());

  factory ShipmentModel.fromJson(String source) =>
      ShipmentModel.fromMap(json.decode(source));
}
