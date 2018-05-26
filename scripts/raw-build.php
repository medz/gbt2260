#!/usr/bin/env php
<?php

declare(strict_types=1);

$sourceMcaTsvUrl = 'https://github.com/cn/GB2260/raw/develop/mca/201801.tsv';

// Get headers.
echo "\033[45;37;5m [1] \033[0m", ' 📡 Start downloading index info...', PHP_EOL;
$headers = get_headers($sourceMcaTsvUrl, 1);
echo '    > ', "\033[0;32;5m", 'Index Info downloaded.', "\033[0m", PHP_EOL;

// Parse header.
$fileContentRawUrl = $headers['Location'];
$fileContentLength = max(...array_map(function ($length): int {
    return (int) $length;
}, (array) $headers['Content-Length']));
echo '    ☛ Download file size is [', "\033[0;31;5m", $fileContentLength, "\033[0m", ' Byte].', PHP_EOL;

$sourceMcaTsvContent = '';
echo "\033[45;37;5m [2] \033[0m 🚚 Start downloading...", PHP_EOL;
echo "    > Download URL is [\033[0;33;5m$fileContentRawUrl\033[0m]", PHP_EOL;
$sourceMcaTsvContentResource = fopen($sourceMcaTsvUrl, 'r', false);

echo "    🐌 Downloading... \033[0;36;5m[0/$fileContentLength]\033[0m";
while(!feof($sourceMcaTsvContentResource)) {
    $sourceMcaTsvContent .= fgets($sourceMcaTsvContentResource);
    // echo($demo);
    $length = strlen($sourceMcaTsvContent);
    echo "\r    🐌 Downloading... \033[0;36;5m[$length/$fileContentLength]\033[0m";
}
echo PHP_EOL;

echo "\033[45;37;5m [3] \033[0m 🛠  Analysis data...", PHP_EOL;
echo "    😱 Exploding data...", PHP_EOL;
$data = explode(PHP_EOL, $sourceMcaTsvContent);
array_shift($data);
$data = array_filter($data);

$start = 0;
$allLength = count($data);
$newData = [];
echo "    🙈 Parsing... \033[0;36;5m[$start/$allLength]\033[0m";
foreach ($data as $value) {
    preg_match('/mca\s+\d+\s+(\d+)\s+(\S+)/is', $value, $matches);
    $start++;
    $newData[$matches[1]] = $matches[2];
    echo "\r    🙈 Parsing... \033[0;36;5m[$start/$allLength]\033[0m";
}
echo PHP_EOL;

$filename = __DIR__.'/../resources/gb-t-2260.json';
file_put_contents($filename, json_encode($newData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
$filename = realpath($filename);
echo "\033[45;37;5m [4] \033[0m 📦 Writing to \033[0;32;5m$filename\033[0m", PHP_EOL;
echo PHP_EOL, "          🎉 \033[0;32;5m Successfully Built\033[0m ✨", PHP_EOL, PHP_EOL;
