<?php

/**
 * @brief       Generates a boilerplate class for Content Nodes
 * @author      Makoto Fujimoto <makoto@makoto.io>
 * @copyright   (c) 2015 Makoto Fujimoto
 * @license     <a href='http://opensource.org/licenses/MIT'>MIT License</a>
 * @since       08 Dec 2015
 */

namespace PowerTools\Command\Generate;

use PowerTools\Console\GenerateCommand;
use PowerTools\Console\Question;
use PowerTools\Parsers\ClassNamespace;
use PowerTools\Template\Template;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ContentNodeCommand extends GenerateCommand
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

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$question = $this->getHelper('question');
		$this->assignNamespaceAttributes( new ClassNamespace( $input->getArgument('namespace') ) );

		// Database information
		$this->databaseTable = $question->ask(
				$input, $output,
				new Question('Database table', "{$this->appDir}_categories")
		);
		$this->databasePrefix = $question->ask(
				$input, $output,
				new Question('Database prefix', '')
		);
		$this->databaseColumnId = $question->ask(
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

		$template = $this->generateTemplate( 'content/node.php' );
		$this->writeTemplate( $template );
	}
}