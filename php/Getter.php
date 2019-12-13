<?php

declare(strict_types=1);

namespace Medz\GBT2260;

class Getter
{
    static protected $year;
    static protected $resource;
    static protected $cache;
    static protected $instance;

    private function __construct()
    {
        $alias = file_get_contents(realpath(__DIR__.'/../resources/last.alias'));
        static::$year = $alias;
        static::$resource = json_decode(file_get_contents(realpath(__DIR__.'/../resources/'.$alias.'.json')), true);
    }

    static public function instance(): Getter
    {
        if (static::$instance instanceof Getter) {
            return static::$instance;
        }

        return static::$instance = new Getter;
    }

    public function province(string $code): ?string
    {
        $provinceCode = substr($code, 0, 2).'0000';

        if (isset(static::$resource[$provinceCode])) {
            return static::$resource[$provinceCode];
        }

        return $this->_previousGetter(static::$year, static::$resource, $provinceCode);
    }

    public function city(string $code): ?string
    {
        $cityCode = substr($code, 0, 4).'00';
        if (isset(static::$resource[$cityCode])) {
            return static::$resource[$cityCode];
        }

        return $this->_previousGetter(static::$year, static::$resource, $cityCode);
    }

    public function county(string $code): ?string
    {
        if (isset(static::$resource[$code])) {
            return static::$resource[$code];
        }

        return $this->_previousGetter(static::$year, static::$resource, $code);
    }

    protected function _previousGetter($year, array $resource, string $code): ?string
    {
        if ($year == 1980) {
            return null;
        }
        $cache = $this->_getCache($year);

        foreach($cache['added'] as $_code => $name) {
            $resource[$_code] = $name;
        }
        foreach($cache['deleted'] as $_code => $name) {
            unset($resource[$_code]);
        }

        if (isset($resource[$code])) {
            return $resource[$code];
        } else if ($year == 1980) {
            return null;
        }

        return $this->_previousGetter((string) ($year - 1), (array) $resource, (string) $code);
    }

    protected function _getCache($year) {
        $key = "{$year}-previous";
        if (!isset(static::$cache[$key])) {
            $path = realpath(__DIR__.'/../resources/diff/'.$key.'.json');
            static::$cache[$key] = json_decode(file_get_contents($path), true);
        }
        
        return static::$cache[$key];
    }
}
