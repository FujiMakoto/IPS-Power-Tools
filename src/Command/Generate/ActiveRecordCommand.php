<?php

/**
 * @brief       Generates a boilerplate class for the ActiveRecord pattern
 * @author      Makoto Fujimoto <makoto@makoto.io>
 * @copyright   (c) 2015 Makoto Fujimoto
 * @license     <a href='http://opensource.org/licenses/MIT'>MIT License</a>
 * @since       09 Dec 2015
 */

namespace PowerTools\Command\Generate;

use PowerTools\Console\GenerateCommand;
use PowerTools\Parsers\ClassNamespace;
use PowerTools\Template\Template;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class ActiveRecordCommand extends GenerateCommand
{
	public $databaseTable;
	public $databaseColumnId;

	protected function configure()
	{
		$this
			->setName('generate:activerecord')
			->setDescription('Generates an Active Record boilerplate class')
			->addArgument(
				'namespace',
				InputArgument::REQUIRED,
				'The namespace for the desired active record class'
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
				new Question('Database Table', "{$this->appDir}_records")
		);
		$this->databaseColumnId = $question->ask(
				$input, $output,
				new Question('Database Column ID', 'id')
		);

		$template = $this->generateTemplate( 'activerecord.php' );
		$this->writeTemplate( $template );
	}
}