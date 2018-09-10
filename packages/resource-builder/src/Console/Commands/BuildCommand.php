<?php

declare(strict_types=1);

namespace Medz\GBT2260\ResourceBuilder\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Medz\GBT2260\ResourceBuilder\Application;
use Medz\GBT2260\ResourceBuilder\Builder\Builder;

class BuildCommand extends Command
{
	protected $builder;

	/**
	 * Create the command instance.
	 * @param \Medz\GBT2260\ResourceBuilder\Application $app
	 */
	public function __construct(Builder $builder)
	{
		$this->builder = $builder;
		parent::__construct();
	}

	/**
	 * Configure the command.
	 * @return void
	 */
	protected function configure()
	{
		$this
			// the name of the command
			->setName('build')
			// the short description shown while running
			->setDescription('Build GB/T 2260 resources')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->builder->handle($output);
	}
}
