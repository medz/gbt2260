import 'dart:convert';
import 'dart:io';

void main() async {
  /// Resource format:
  /// {
  ///   "110000": "北京市",
  // "110101": "东城区",
  // "110102": "西城区",
  // "110103": "崇文区",
  // "110104": "宣武区",
  // "110105": "朝阳区",
  // "110106": "丰台区",
  // "110107": "石景山区",
  // "110108": "海淀区",
  // "110109": "门头沟区",
  // "110110": "燕山区",
  // "110201": "昌平县",
  // "110202": "顺义县",
  // "110203": "通县",
  // "110204": "大兴县",
  // "110205": "房山县",
  // "110206": "平谷县",
  // "110207": "怀柔县",
  // "110208": "密云县",
  // "110209": "延庆县",
  // "120000": "天津市",
  // "120101": "和平区",
  // "120102": "河东区",
  // "120103": "河西区",
  // "120104": "南开区",
  /// }
  final source = readResopurce();

  // 使用 source 创造一个 kv 文件，并保存到本地
  // kv 文件格式为：
  // 11 <> 北京市
  // 110101 <> 东城区
  // 110102 <> 西城区
  // 110103 <> 崇文区
  final kv =
      source.map((k, v) => MapEntry(k, '${removeEndZero(k)} <> $v')).values;

  final file = File('data.kv');
  await file.writeAsString(kv.join('\n'));
}

// Read '1980.json' and parse it as a JSON object.
Map<String, dynamic> readResopurce() {
  final File file = File('resources/1980.json');

  return json.decode(file.readAsStringSync());
}

// Remove string end '0' from a string.
// E.g: 110000 -> 11
String removeEndZero(String str) {
  if (str.endsWith('0')) {
    return removeEndZero(str.substring(0, str.length - 1));
  }

  return str;
}
