<?php

/**
 * @brief       Generates a boilerplate class for Content Items
 * @author      Makoto Fujimoto <makoto@makoto.io>
 * @copyright   (c) 2015 Makoto Fujimoto
 * @license     <a href='http://opensource.org/licenses/MIT'>MIT License</a>
 * @since       08 Dev 2015
 */

namespace PowerTools\Command\Generate;

use PowerTools\Console\GenerateCommand;
use PowerTools\Parsers\ClassNamespace;
use PowerTools\Template\Template;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class ContentItemCommand extends GenerateCommand
{
	public $classNamespace = '';
	public $className = '';

	public $appDir = '';
	public $module = '';

	public $databaseTable = '';
	public $databasePrefix = '';
	public $databaseColumnId = '';

	public $containerNodeClass = '';
	public $commentClass = '';
	public $reviewClass = '';

	public $dbMap = FALSE;
	public $dbMapContainer = NULL;
	public $dbMapAuthor = NULL;
	public $dbMapViews = NULL;
	public $dbMapTitle = NULL;
	public $dbMapContent = NULL;
	public $dbMapNumComments = NULL;
	public $dbMapLastComment = NULL;
	public $dbMapLastCommentBy = NULL;
	public $dbMapLastCommentName = NULL;
	public $dbMapLastReview = NULL;
	public $dbMapDate = NULL;
	public $dbMapUpdated = NULL;
	public $dbMapApproved = NULL;
	public $dbMapApprovedBy = NULL;
	public $dbMapApprovedDate = NULL;
	public $dbMapPinned = NULL;
	public $dbMapFeatured = NULL;
	public $dbMapLocked = NULL;
	public $dbMapIpAddress = NULL;

	public $title = '';
	public $icon = '';
	public $hideLogKey = '';
	public $formLangPrefix = '';
	public $reputationType = '';

	protected function configure()
	{
		$this
			->setName('generate:content-item')
			->setDescription('Generates a Content Item boilerplate class')
			->addArgument(
				'namespace',
				InputArgument::REQUIRED,
				'The namespace for the desired content item class'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$question = $this->getHelper('question');
		$this->assignNamespaceAttributes( new ClassNamespace( $input->getArgument('namespace') ) );

		$this->module = $question->ask(
				$input, $output,
				new Question('Module', $this->appDir)
		);

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
		$this->containerNodeClass = $question->ask(
				$input, $output,
				new Question('Container Node Class')
		);
		$this->commentClass = $question->ask(
				$input, $output,
				new Question('Comment Class')
		);
		$this->reviewClass = $question->ask(
				$input, $output,
				new Question('Review Class')
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
			$this->dbMapContainer = $question->ask(
					$input, $output,
					new Question('Container ID', 'category_id')
			);

			# General data
			$this->dbMapAuthor = $question->ask(
					$input, $output,
					new Question('Author', 'author_id')
			);
			$this->dbMapTitle = $question->ask(
					$input, $output,
					new Question('Title', 'title')
			);
			$this->dbMapContent = $question->ask(
					$input, $output,
					new Question('Content', 'content')
			);
			$this->dbMapViews = $question->ask(
					$input, $output,
					new Question('View count', 'views')
			);

			# Comments
			$this->dbMapNumComments = $question->ask(
					$input, $output,
					new Question('Comment count', 'num_comments')
			);
			$this->dbMapLastComment = $question->ask(
					$input, $output,
					new Question('Last comment ID', 'last_comment')
			);
			$this->dbMapLastCommentBy = $question->ask(
					$input, $output,
					new Question('Last comment author', 'last_comment_by')
			);
			$this->dbMapLastCommentName = $question->ask(
					$input, $output,
					new Question('Last comment author name', 'last_comment_name')
			);

			# Reviews
			$this->dbMapLastReview = $question->ask(
					$input, $output,
					new Question('Last review ID', 'last_review')
			);

			# Dates
			$this->dbMapDate = $question->ask(
					$input, $output,
					new Question('Submission date', 'date')
			);
			$this->dbMapUpdated = $question->ask(
					$input, $output,
					new Question('Last updated date', 'updated')
			);

			# Approval information
			$this->dbMapApproved = $question->ask(
					$input, $output,
					new Question('Approval status', 'approved')
			);
			$this->dbMapApprovedBy = $question->ask(
					$input, $output,
					new Question('Member ID of the approving user', 'approved_by')
			);
			$this->dbMapApprovedDate = $question->ask(
					$input, $output,
					new Question('Approval date', 'approved_date')
			);

			# Flags
			$this->dbMapPinned = $question->ask(
					$input, $output,
					new Question('Pinned flag', 'pinned')
			);
			$this->dbMapFeatured = $question->ask(
					$input, $output,
					new Question('Featured flag', 'featured')
			);
			$this->dbMapLocked = $question->ask(
					$input, $output,
					new Question('Locked flag', 'locked')
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
				new Question('Icon', 'file')
		);

		$this->hideLogKey = $question->ask(
				$input, $output,
				new Question('Hide log key')
		);

		$this->formLangPrefix = $question->ask(
				$input, $output,
				new Question('Form language prefix', "{$this->appDir}_")
		);

		$this->reputationType = $question->ask(
				$input, $output,
				new Question('Reputation type', 'id')
		);

		$template = $this->generateTemplate( 'content/item.php' );
		$this->writeTemplate( $template );
	}
}