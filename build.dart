import 'dart:convert';
import 'dart:io';

const String lastYear = '1983';
const String firstYear = '1982';

void main() async {
  final last = readResopurce('./resources/$lastYear.json');
  final first = readResopurce('./resources/$firstYear.json');

  // last 相较于 first
  Map added = {};
  Map nameChanged = {};
  for (var element in last.entries) {
    if (first.containsKey(element.key) && last.containsKey(element.key)) {
      if (first[element.key] != last[element.key]) {
        nameChanged['${element.key} <> ${first[element.key]}'] =
            last[element.key];
        continue;
      }
    }

    if (!first.containsKey(element.key)) {
      added[element.key] = element.value;
    }
  }

  final removed = {};
  for (var element in first.entries) {
    if (!last.containsKey(element.key)) {
      removed[element.key] = element.value;
    }
  }

  // 写入到 diff 文件
  final file = File('./diff.txt');
  String changedString = '';
  String addedString = '';
  String removedString = '';

  for (var element in nameChanged.entries) {
    changedString += '${element.key} > ${element.value}\n';
  }

  for (var element in added.entries) {
    addedString += '${element.key} <> ${element.value}\n';
  }

  for (var element in removed.entries) {
    removedString += '${element.key} <> ${element.value}\n';
  }

  await file.writeAsString('''
====== $lastYear 相较于 $firstYear ======

改名的：
$changedString
==============
新增的：
$addedString
==============
移除的：
$removedString
''');
}

// Read file and parse it as a JSON object.
Map<String, dynamic> readResopurce(String path) {
  final File file = File(path);

  // return {};

  return json.decode(file.readAsStringSync());
}
