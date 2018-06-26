<?php

declare(strict_types=1);

namespace Medz\GBT2260\ResourceBuilder;

use Illuminate\Container\Container;

class Application extends Container
{
	/**
	 * The app name.
	 */
	public const NAME = 'GB/T 2260 Builder';

	/**
	 * The app version.
	 */
	public const VERSION = '2.0.0';

	/**
	 * Create the instance.
	 */
	public function __construct()
	{
		// Set the Application is instance.
		static::setInstance($this);

		// Register aliases.
		$this->registerAliases();
	}

	/**
	 * the app run handle.
	 *
	 * @return int
	 */
	public function run()
	{
		// Get console app instance.
		$app = $this->getConsoleAppLication();

		// // Add builder command.
		// $app->add(
		// 	// Get builder command instance.
		// 	$builderCommand = $this->make(Console\Commands\Builder::class);
		// );

		// // Ser builder command is default command.
		// $app->setDefaultCommand($builderCommand->getName());

		// Run console app,
		// return exit code.
		return $app->run();
	}

	/**
	 * Get console instance.
	 *
	 * @return
	 */
	public function getConsoleAppLication()
	{
		return $this->make(Console\Application::class);
	}

	/**
	 * Get the app name.
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return static::NAME;
	}

	/**
	 * Get the app version.
	 *
	 * @return string
	 */
	public function getVersion(): string
	{
		return static::VERSION;
	}

	protected function registerAliases()
	{
		foreach ([
			'app' => [
				\Medz\GBT2260\ResourceBuilder\Application::class,
				\Illuminate\Contracts\Container\Container::class,
				\Illuminate\Container\Container::class,
				\Psr\Container\ContainerInterface::class
			],
			'console' => [
				Medz\GBT2260\ResourceBuilder\Console\Application::class,
				Symfony\Component\Console\Application::class,
			],
		] as $abstract => $aliases) {
			foreach ($aliases as $alias) {
				$this->alias($abstract, $alias);
			}
		}
	}
}