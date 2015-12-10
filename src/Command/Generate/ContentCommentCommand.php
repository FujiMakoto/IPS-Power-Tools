<?php

/**
 * @brief       Generates a boilerplate class for Content Comments
 * @author      Makoto Fujimoto <makoto@makoto.io>
 * @copyright   (c) 2015 Makoto Fujimoto
 * @license     <a href='http://opensource.org/licenses/MIT'>MIT License</a>
 * @since       08 Dev 2015
 */

namespace PowerTools\Command\Generate;

use PowerTools\Parsers\ClassNamespace;
use PowerTools\Template\Template;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class ContentCommentCommand extends Command
{
	public $classNamespace = '';
	public $className = '';

	public $appDir = '';
	public $module = '';

	public $databaseTable = '';
	public $databasePrefix = '';
	public $databaseColumnId = '';

	public $itemClass = '';

	public $dbMap = FALSE;
	public $dbMapItem = NULL;
	public $dbMapAuthor = NULL;
	public $dbMapAuthorName = NULL;
	public $dbMapContent = NULL;
	public $dbMapDate = NULL;
	public $dbMapEditTime = NULL;
	public $dbMapEditName = NULL;
	public $dbMapEditShow = NULL;
	public $dbMapApproved = NULL;
	public $dbMapIpAddress = NULL;

	public $title = '';
	public $icon = '';
	public $hideLogKey = '';
	public $reputationType = '';

	protected function configure()
	{
		$this
			->setName('generate:content-comment')
			->setDescription('Generates a Content Comment boilerplate class')
			->addArgument(
				'namespace',
				InputArgument::REQUIRED,
				'The namespace for the desired content comment class'
			)
		;
	}

	protected function generateTemplate()
	{
		$template = new Template();

		foreach ( get_object_vars( $this ) as $key => $value )
		{
			$template->{$key} = $value;
		}

		return $template->render( 'phar://ptools/templates/content/comment.php' );
	}

	protected function writeTemplate( $template )
	{
		file_put_contents( 'test.php', $template );
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
				new Question('Database Table', "{$this->appDir}_items")
		);
		$this->databasePrefix = $question->ask(
				$input, $output,
				new Question('Database Prefix', '')
		);
		$this->databasePrefix = $question->ask(
				$input, $output,
				new Question('Database Column ID', 'id')
		);

		// Class information
		$this->itemClass = $question->ask(
				$input, $output,
				new Question('Item Class')
		);

		// Database Column Maps
		$this->dbMap = $question->ask(
				$input, $output,
				new ConfirmationQuestion(
						'<question>Do you want to configure the database column maps now?</question>', FALSE
				)
		);

		if ( $this->dbMap )
		{
			# Container
			$this->dbMapItem = $question->ask(
					$input, $output,
					new Question('Item ID', 'item_id')
			);

			# General data
			$this->dbMapAuthor = $question->ask(
					$input, $output,
					new Question('Author', 'author_id')
			);
			$this->dbMapAuthorName = $question->ask(
					$input, $output,
					new Question('Author name', 'author_name')
			);
			$this->dbMapContent = $question->ask(
					$input, $output,
					new Question('Content', 'text')
			);

			# Dates
			$this->dbMapDate = $question->ask(
					$input, $output,
					new Question('Submission date', 'date')
			);
			$this->dbMapEditTime = $question->ask(
					$input, $output,
					new Question('Last edit date', 'edit_time')
			);
			$this->dbMapEditName = $question->ask(
					$input, $output,
					new Question('Edit author name', 'edit_name')
			);
			$this->dbMapEditShow = $question->ask(
					$input, $output,
					new Question('Show edit flag', 'append_edit')
			);

			# Approval information
			$this->dbMapApproved = $question->ask(
					$input, $output,
					new Question('Approval status', 'approved')
			);

			$this->dbMapIpAddress = $question->ask(
					$input, $output,
					new Question('Submitter IP Address', 'ipaddress')
			);
		}

		$this->title = $question->ask(
				$input, $output,
				new Question('Title')
		);

		$this->icon = $question->ask(
				$input, $output,
				new Question('Icon', 'comment')
		);

		$this->hideLogKey = $question->ask(
				$input, $output,
				new Question('Hide log key')
		);

		$this->reputationType = $question->ask(
				$input, $output,
				new Question('Reputation type', 'id')
		);

		$template = $this->generateTemplate();
		$this->writeTemplate( $template );
	}
}