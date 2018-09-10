<?php

declare(strict_types=1);

namespace Medz\GBT2260\ResourceBuilder\Builder;

use Medz\GBT2260\ResourceBuilder\Origin;
use Symfony\Component\Console\Output\OutputInterface;
use Medz\GBT2260\ResourceBuilder\ResourceDefinition;

class Builder
{
    protected $origin;
    protected $download;

    public function __construct(Origin $origin, Download $download)
    {
        $this->origin = $origin;
        $this->download = $download;
    }

    public function handle(OutputInterface $output)
    {
        $map = [];
        foreach ($this->origin as $year => $url) {
            $this->download($output, (int) $year, $url);
            array_push($map, $year);
        }

        file_put_contents(
            sprintf('%s/map.json', ResourceDefinition::RESOURCE_DIR),
            json_encode($map, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }

    protected function download(OutputInterface $output, int $year, string $url)
    {
        $output->writeln(sprintf('Downloading <comment>%d</comment> year data from <info>%s</info>', $year, $url));
        $this->download->download(
            $url,
            sprintf('%s/%d.json', ResourceDefinition::RESOURCE_DIR, $year)
        );
    }
}
