# GB/T 2260

中华人民共和国国家标准 GB/T 2260 行政区划代码

`tb-t-2260`，为什么会是一个这个丑的字符串呢？很简单，因为 `GB/T 2260` 进行简单的「中横线处理」后就是了。（比较符合程序员思维，你懂我的意思吧？）

`GB/T 2260` 国家推荐县级以上行政区规划代码，记住，很多仓库都忽略了 `T`，这个 T 就是推荐的意思，国家发布的标准是 `GB/T` 而不是 `GB`（国标）哟！

那么这个仓库做的事情很简单，就是将最新的 `GB/T 2260` 数据整理后提供给你，所以这个仓库是不包含代码的，但是对不同的语言和包管理工具提供了不同的使用方法，但是使用的数据源都是一个。

## 允许使用途径

- Git (好的，这个不用说了，你用 Git 克隆后你自己就知道怎么做了)
- [PHP (Using Composer)](#php)
- [JavaScript (Using NPM or Yarn)](#javascript)

### 使用

无论你用何种方式，使用的 RAW 内容均为 **`resources/gb-t-2260.json`** 这一份文件的内容，它的结构很简单，下面是一份预览：

```json5
{
    "110000": "北京市",
    "110101": "东城区",
    "110102": "西城区",
    "110105": "朝阳区",
    // ...
}
```

> 其中 `Key` 就是行政代码，而 `Value` 就是代码对应的地区县名称。

### PHP

使用 PHP 版本，你可以使用 Composer 快速的下载：

```
composer require medz/gb-t-2260
```

下载后，这个包提供了地区 JSON RAW 文件和一个 PHP 常量，常量叫做 **`MEDZ_GBT2260_RAW_PATH`**，顾名思义，这个常量就是记录的 JSON RAW 文件的路径，得到路径你就可以自由操作了。例如：

```php
$jsonRaw = file_get_contents(MEDZ_GBT2260_RAW_PATH);
$jsonObject = json_decode($jsonRaw);

// 现在你可以分别 dump 出两个变量，看其中的内容
```

### JavaScript

你可以使用 NPM 或者 Yarn 任意一个工具，但是推荐你的项目是允许进行 `require` JSON 文件的导入功能的。

```bash
# NPM
npm -i gb-t-2260

# Yarn
yarn add gb-t-2260
```

现在，你已经把 `GB/T 2260` 添加到你的项目中了，我们来使用使用一下吧！

```javascript
let jsonObject = require('gb-t-2260');

console.log(jsonObject);
console.log(jsonObject['110000']); // > 北京市
```
