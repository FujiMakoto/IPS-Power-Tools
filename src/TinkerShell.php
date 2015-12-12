<?php

/**
 * @brief       PsyShell integration for the Invision Power Suite
 * @author      Makoto Fujimoto <makoto@makoto.io>
 * @copyright   (c) 2015 Makoto Fujimoto
 * @license     <a href='http://opensource.org/licenses/MIT'>MIT License</a>
 * @since       06 Dec 2015
 */

namespace PowerTools;

use Psy\Configuration;
use Psy\Shell;

/**
 * Class TinkerShell.
 */
class TinkerShell
{
	/**
	 * PsySH Shell.
	 * @var Shell
	 */
	protected $shell;

	/**
	 * Set files that should be included on shell.
	 *
	 * @param $include
	 * @return $this
	 */
	public function setIncludes($include)
	{
		$this->getShell()->setIncludes($include);

		return $this;
	}

	/**
	 * Get instance of the Shell.
	 * @return \Psy\Shell
	 */
	public function getShell()
	{
		if (!$this->shell) {
			$config = new Configuration();

			/*$config->getPresenter()->addCasters(
				$this->getCasters()
			);*/

			$this->shell = new Shell($config);

			//$this->shell->addCommands($this->getCommands());
		}

		return $this->shell;
	}

	/**
	 * Run the shell.
	 */
	public function run()
	{
		$this->getShell()->run();
	}
}