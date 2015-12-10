<?php

/**
 * @brief       Generates a boilerplate class for Content Items
 * @author      Makoto Fujimoto <makoto@makoto.io>
 * @copyright   (c) 2015 Makoto Fujimoto
 * @license     <a href='http://opensource.org/licenses/MIT'>MIT License</a>
 * @since       08 Dev 2015
 */

namespace PowerTools\Console\Generate;

use PowerTools\Parsers\ClassNamespace;
use PowerTools\Template\Template;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class ContentNodeCommand extends Command
{
	public $classNamespace = '';
	public $className = '';

	public $appDir = '';
	public $module = '';

	public $databaseTable = '';
	public $databasePrefix = '';
	public $databaseColumnId = '';
	public $databaseColumnOrder = '';
	public $databaseColumnParent = '';

	public $itemClass = '';

	public $title = '';

	protected function configure()
	{
		$this
			->setName('generate:content-node')
			->setDescription('Generates a Content Node boilerplate class')
			->addArgument(
				'namespace',
				InputArgument::REQUIRED,
				'The namespace for the desired content node class'
			)
		;
	}

	protected function generateTemplate()
	{
		$template = new Template();

		foreach ( get_object_vars( $this ) as $key => $value )
		{
			if ( !in_array( $key, [ 'classNamespace', 'className', 'appDir', 'module' ] ) )
			{
				$value = $this->quoteOrNull( $value );
			}

			$template->{$key} = $value;
		}

		return $template->render( 'phar://ptools/templates/content/node.php' );
	}

	protected function writeTemplate( $template )
	{
		file_put_contents( 'test.php', $template );
	}

	protected function quoteOrNull( $value )
	{
		return !is_null( $value ) ? "'" . str_replace( "'", "\\'", $value ) . "'" : 'NULL';
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$question = $this->getHelper('question');

		// Load settings
		$namespace = new ClassNamespace( $input->getArgument('namespace') );
		$this->classNamespace = $namespace->classNamespace;
		$this->appDir = $namespace->appDir;
		$this->className = $namespace->className;

		// Database information
		$this->databaseTable = $question->ask(
				$input, $output,
				new Question('Database table', "{$this->appDir}_categories")
		);
		$this->databasePrefix = $question->ask(
				$input, $output,
				new Question('Database prefix', '')
		);
		$this->databasePrefix = $question->ask(
				$input, $output,
				new Question('Database column ID', 'id')
		);
		$this->databaseColumnOrder = $question->ask(
			$input, $output,
			new Question('Database column order')
		);
		$this->databaseColumnParent = $question->ask(
			$input, $output,
			new Question('Database column parent')
		);

		// Class information
		$this->itemClass = $question->ask(
				$input, $output,
				new Question('Item class')
		);

		$this->title = $question->ask(
				$input, $output,
				new Question('Title')
		);

		$template = $this->generateTemplate();
		$this->writeTemplate( $template );
	}
}