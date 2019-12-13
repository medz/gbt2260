<?php

declare(strict_types=1);

namespace Medz\GBT2260\ResourceBuilder;

use GuzzleHttp\Client as Http;

class Download
{
    protected $http;

    public function __construct()
    {
        $this->http = new Http;
    }

    public function download(string $url, string $filename)
    {
        $response = $this->http->get($url);
        if ($response->getStatusCode() !== 200) {
            printf('Download request error!');
            exit;
        }

        $contents = $response->getBody()->getContents();
        $contents = str_replace(' ', '', $contents);
        preg_match_all('/\<tr.*?\>(.*?)\<\/tr\>/is', $contents, $matches);
        $data = [];
        foreach($matches[1] as $item) {
            $isMatch = preg_match('/\<td.*?\>(\w+)\<\/td\>.*?\<td.*?\>(.*?)\<\/td\>.*?/is', $item, $match);
            if ($isMatch) {
                preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $match[2], $matches);
                $data[$match[1]] = join('', $matches[0]);
            }
        }

        file_put_contents($filename, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
