<?php


namespace PowerTools\Console;


class Question extends \Symfony\Component\Console\Question\Question
{
	/**
	 * Modify our question on construct to apply some pretty formatting.
	 *
	 * @param   string  $question   The question to ask to the user
	 * @param   mixed   $default    The default answer to return if the user enters nothing
	 */
	public function __construct( $question, $default=NULL )
	{
		// Append our default value?
		if ( $default !== NULL )
		{
			$question = $question . " <comment>[default: \"{$default}\"]</comment>";
		}

		$question = $question . ': ';
		parent::__construct( $question, $default );
	}
}