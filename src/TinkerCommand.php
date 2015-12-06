<?php

/**
 * @brief       PsyShell integration for the Invision Power Suite
 * @author      Makoto Fujimoto <makoto@makoto.io>
 * @copyright   (c) 2015 Makoto Fujimoto
 * @license     <a href='http://opensource.org/licenses/MIT'>MIT License</a>
 * @since       06 Dev 2015
 * @version     1.0.0
 */

namespace PowerTools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TinkerCommand.
 */
class TinkerCommand extends Command
{
	protected function configure()
	{
		$this
			->setName('tinker')
			->setDescription('Launches an interactive shell interpreter for your IPS installation')
		;
	}

	/**
	 *  Performs the event.
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$shell = new TinkerShell();
		$shell->setIncludes([getcwd() . \DIRECTORY_SEPARATOR . 'init.php'])->run();
	}
}