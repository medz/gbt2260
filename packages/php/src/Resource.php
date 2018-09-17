<?php

declare(strict_types=1);

namespace Medz\GBT2260;

class Resource
{
    protected $map = [];

    public function __construct()
    {
        $map = file_get_contents(__DIR__.'/../../../resources/map.json');
        $map = json_decode($map, false);
        foreach ($map as $year) {
            $this->map[$year] = __DIR__.'../../../resources/'.$year.'.json';
        }
    }

    public function getYears(): array
    {
        return array_keys($this->getMap());
    }

    public function getMap(): array
    {
        return $this->map;
    }

    public function getData(int $year): ?array
    {
        if (! isset($this->map[$year])) {
            return null;
        }

        return json_decode(file_get_contents($this->map[$year]), false);
    }
}
