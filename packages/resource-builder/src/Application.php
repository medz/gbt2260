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
		// Register aliases.
		$this->registerAliases();

		// Set the Application is instance.
		static::setInstance($this)
			->instance(static::class, $this);
	}

	/**
	 * the app run handle.
	 *
	 * @return int
	 */
	public function run()
	{
		// Get console app instance.
		$app = $this->getConsoleApplication();

		// Add Build command.
		$app->add(
			// Get builder command instance.
			$buildCommand = $this->make(Console\Commands\BuildCommand::class)
		);

		// Run console app,
		// return exit code.
		return $app->run();
	}

	/**
	 * Get console instance.
	 *
	 * @return
	 */
	public function getConsoleApplication()
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

	/**
	 * Register aliases.
	 * @return void
	 */
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
