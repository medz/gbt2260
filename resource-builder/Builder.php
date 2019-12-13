<?php

declare(strict_types=1);

namespace Medz\GBT2260\ResourceBuilder;

class Builder
{
    protected $lock;
    protected $origin;
    protected $download;

    public function __construct()
    {
        $this->lock = new OriginArrayable(__DIR__.'/.origin.lock');
        $this->origin = new OriginArrayable(__DIR__.'/.origin.json');
    }

    protected function download(string $url, string $path)
    {
        if (!($this->download instanceof Download)) {
            $this->download = new Download;
        }
        
        return $this->download->download($url, __DIR__.'/../resources/'.$path.'.json');
    }

    public function run()
    {
        // 写入别名文件
        file_put_contents(__DIR__.'/../resources/last.alias', $this->origin->last);

        // 下载文件
        foreach ($this->origin->resources as $key => $url) {
            if ($this->lock->{$key} === true) {
                continue;
            }

            echo "Downloading {$url}", PHP_EOL;
            $this->download($url, (string) $key);
            if ($key != $this->origin->last) {
                $this->lock->{$key} = true;
            }
        }
        $this->lock->save();

        $this->diff();
    }

    protected function diff()
    {
        echo 'Diffing...', PHP_EOL;
        $keys = array_keys($this->origin->resources);
        rsort($keys);

        $_key;
        $resource;
        foreach ($keys as $key) {
            if ($key == $this->origin->last) {
                $_key = $key;
                $resource = json_decode(file_get_contents(__DIR__.'/../resources/'.$key.'.json'), true);
                continue;
            }

            $_temp = json_decode(file_get_contents(__DIR__.'/../resources/'.$key.'.json'), true);
            $added = array_diff($resource, $_temp);
            $deleted = array_diff($_temp, $resource);
            $diff2 = json_encode([
                'added' => $added,
                'deleted' => $deleted,
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $diff1 = json_encode([
                'added' => $deleted,
                'deleted' => $added,
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            
            if ($key != 1980) {
                file_put_contents(__DIR__.'/../resources/diff/'.$_key.'-previous.json', $diff1);
            }
            file_put_contents(__DIR__.'/../resources/diff/'.$key.'-next.json', $diff2);

            $resource = $_temp;
            $_key = $key;
        }
    }
}
