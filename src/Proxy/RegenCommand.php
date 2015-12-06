<?php

/**
 * @brief           ipsProxy Generator (Originally authored by Michael, Modified by Makoto for use with Power Tools)
 * @author          <a href='http://codingjungle.com'>Michael S. Edwards</a>
 * @author          Makoto Fujimoto <makoto@makoto.io>
 * @license         http://opensource.org/licenses/MIT
 * @package         Power Tools
 * @since           29 Mar 2015
 * @version         1.0.0
 */

namespace PowerTools\Proxy;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RegenCommand extends Command
{
	protected function configure()
	{
		$this
			->setName('proxy:regen')
			->setDescription('(Re)generates all proxy classes for the application')
			->addOption(
				'path',
				'p',
				InputOption::VALUE_OPTIONAL,
				'Directory path to store the generated proxy classes in',
				'proxy_classes'
			)
			->addOption(
				'skip-extensions',
				null,
				InputOption::VALUE_NONE,
				'If set, proxy classes for extensions will not be generated'
			)
			->addOption(
				'skip-modules',
				null,
				InputOption::VALUE_NONE,
				'If set, proxy classes for front and admin modules will not be generated'
			)
			->addOption(
				'skip-hooks',
				null,
				InputOption::VALUE_NONE,
				'If set, proxy classes for hooks will not be generated'
			)
			->addOption(
				'skip-widgets',
				null,
				InputOption::VALUE_NONE,
				'If set, proxy classes for widgets will not be generated'
			)
			->addOption(
				'skip-tasks',
				null,
				InputOption::VALUE_NONE,
				'If set, proxy classes for tasks will not be generated'
			)
			->addOption(
				'skip-plugins',
				null,
				InputOption::VALUE_NONE,
				'If set, proxy classes for plugins will not be generated'
			)
			->addOption(
				'skip-setup',
				null,
				InputOption::VALUE_NONE,
				'If set, proxy classes for setup files will not be generated'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$skipExtensions = $input->getOption('skip-extensions');
		$skipModules    = $input->getOption('skip-modules');
		$skipHooks      = $input->getOption('skip-hooks');
		$skipWidgets    = $input->getOption('skip-widgets');
		$skipTasks      = $input->getOption('skip-tasks');
		$skipPlugins    = $input->getOption('skip-plugins');
		$skipSetup      = $input->getOption('skip-setup');

		$save_path    = $input->getOption('path');
		$save_basedir = join(\DIRECTORY_SEPARATOR, [getcwd(), \DIRECTORY_SEPARATOR, $save_path]);

		// Check for any existing files
		if ( $output->isVeryVerbose() )
			$output->writeln('Checking for any existing proxy class files in ' . $save_basedir);

		if ( is_dir($save_basedir) )
		{
			$glob_path = join(\DIRECTORY_SEPARATOR, [$save_basedir, '*']);
			$files = glob($glob_path);

			if ( $output->isVerbose() )
				$output->writeln( sprintf( 'Removing %d old proxy class files', count($files) ) );
			else
				$output->writeln('Removing old proxy class files');

			// Iterate over the files and delete them
			foreach ($files as $file)
			{
				if ( is_file($file) )
				{
					if ($output->isDebug())
						$output->writeln('Removing file: ' . $file);

					unlink($file);
				}
			}
		}

		// Make sure our base directories exist
		if ( !is_dir($save_basedir) )
		{
			if ( $output->isVeryVerbose() )
				$output->writeln('Creating proxy classes directory: ' . $save_basedir);

			mkdir($save_basedir, 0755);
		}

		$excluded = [$save_path, 'datastore'];

		$filter = function ($file, $key, $iterator) use ($excluded)
		{
			if ( $iterator->hasChildren() && !in_array($file->getFilename(), $excluded) )
			{
				return true;
			}

			return $file->isFile();
		};

		$dirIterator = new \RecursiveDirectoryIterator(
			getcwd(),
			\RecursiveDirectoryIterator::SKIP_DOTS
		);
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveCallbackFilterIterator($dirIterator, $filter),
			\RecursiveIteratorIterator::SELF_FIRST
		);

		// Get a list of files to iterate over
		$files_to_parse = [];
		$iterator = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);
		foreach ($iterator as $file)
			$files_to_parse[] = $file;

		$count = count($files_to_parse);
		if ( $output->isDebug() )
			$output->writeln( count($files_to_parse) . ' files matched' );

		// Start our progress bar and disable the console cursor
		$output->setDecorated(true);
		$output->write("\033[?25l", true);
		$progress = new ProgressBar($output, $count);
		$progress->setFormat(" %namespace%\n %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");

		$i = 0;
		foreach ($files_to_parse as $file)
		{
			$filePath = $file[0];

			$handle = @fopen($filePath, "r");
			if ($handle)
			{
				$namespace = '';

				while ( !feof($handle) )
				{
					$line = fgets($handle, 4096);
					$matches = array();

					// Get the namespace
					preg_match('/^namespace(.+?)([^\;]+)/', $line, $matched);
					if ( isset($matched[0]) )
					{
						$namespace = $matched[0];
					}

					// Filter results
					# Extensions
					if ( mb_strpos($namespace, '\\extensions\\') and $skipExtensions )
					{
						if ( $output->isDebug() )
							$output->writeln('Skipping extension: ' + $filePath);

						$progress->advance();
						continue;
					}

					# Modules
					if ( mb_strpos($namespace, '\\modules\\front\\') or mb_strpos($namespace, '\\modules\\admin\\') )
					{
						if ( $skipModules )
						{
							if ($output->isDebug())
								$output->writeln('Skipping module: ' + $filePath);

							$progress->advance();
							continue;
						}
					}

					# Hooks
					if ( mb_strpos($filePath, \DIRECTORY_SEPARATOR.'hooks'.\DIRECTORY_SEPARATOR) and $skipHooks )
					{
						if ($output->isDebug())
							$output->writeln('Skipping hook: ' + $filePath);

						$progress->advance();
						continue;
					}

					# Widgets
					if ( mb_strpos($filePath, \DIRECTORY_SEPARATOR.'widgets'.\DIRECTORY_SEPARATOR) and $skipWidgets )
					{
						if ($output->isDebug())
							$output->writeln('Skipping widget: ' + $filePath);

						$progress->advance();
						continue;
					}

					# Tasks
					if ( mb_strpos($filePath, \DIRECTORY_SEPARATOR.'tasks'.\DIRECTORY_SEPARATOR) and $skipTasks )
					{
						if ($output->isDebug())
							$output->writeln('Skipping task: ' + $filePath);

						$progress->advance();
						continue;
					}

					# Plugins
					if ( mb_strpos($filePath, \DIRECTORY_SEPARATOR.'plugins'.\DIRECTORY_SEPARATOR) and $skipPlugins )
					{
						if ($output->isDebug())
							$output->writeln('Skipping plugin: ' + $filePath);

						$progress->advance();
						continue;
					}

					# Setup
					if ( mb_strpos($filePath, \DIRECTORY_SEPARATOR.'setup'.\DIRECTORY_SEPARATOR) and $skipSetup )
					{
						if ($output->isDebug())
							$output->writeln('Skipping setup: ' + $filePath);

						$progress->advance();
						continue;
					}

					if (preg_match('#^(\s*)((?:(?:abstract|final|static)\s+)*)class\s+([-a-zA-Z0-9_]+)(?:\s+extends\s+([-a-zA-Z0-9_]+))?(?:\s+implements\s+([-a-zA-Z0-9_,\s]+))?#', $line, $matches) )
					{
						if ( substr($matches[3], 0, 1) === '_' ) {
							$content = '';
							$append = ltrim($matches[3], '\\');

							$m = ltrim($matches[3], '\\');
							$m = str_replace('_', '', $m);

							$content = "<?php\n\n";

							if ($namespace)
								$content .= $namespace . ";\n\n";

							$content .= $matches[2] . 'class ' . $m . ' extends ' . $append . '{}' . "\n";

							$progress->setMessage($namespace, 'namespace');

							$filename = mb_strtolower($m) . '.php';
							$filePath = join( \DIRECTORY_SEPARATOR, [getcwd(), $save_path, $filename] );

							if ( !is_file($filePath) )
							{
								file_put_contents($filePath, $content);
							}
							else
							{
								$alt = str_replace( ["\\", " ", ";"], "_", $namespace );
								$filename = $alt . "_" . $filename;

								$filePath = join( \DIRECTORY_SEPARATOR, [getcwd(), $save_path, $filename] );

								file_put_contents($filePath, $content);
							}

							$i++;
						}
					}
				}
				$progress->advance();
				fclose($handle);
			}
			else
			{
				$progress->advance();
			}
		}

		// Finish and re-enable the cursor
		$progress->finish();
		$output->write("\033[?25h", true);
	}
}