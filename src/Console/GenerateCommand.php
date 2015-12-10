<?php

namespace PowerTools\Console;

use Symfony\Component\Console\Command\Command;

class GenerateCommand extends Command
{
	/**
	 * Return a literal NULL if input is NULL, otherwise wrap the value in single quotes (escaping if needed)
	 *
	 * @param   string  $value
	 * @return  string
	 */
	protected function quoteOrNull( $value )
	{
		return !is_null( $value ) ? "'" . str_replace( "'", "\\'", $value ) . "'" : 'NULL';
	}

	/**
	 * Generate and return a PHP template
	 *
	 * @return  string
	 */
	protected function generateTemplate( $templatePath )
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

		return $template->render( "phar://ptools/templates/{$templatePath}" );
	}

	/**
	 * Write a template file
	 *
	 * @param   string  $template
	 */
	protected function writeTemplate( $template )
	{
		file_put_contents( 'test.php', $template );
	}
}